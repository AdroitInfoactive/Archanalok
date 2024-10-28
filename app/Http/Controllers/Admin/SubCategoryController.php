<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SubCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubCategoryCreateRequest;
use App\Models\Category;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(SubCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.product.sub-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $maincategories = MainCategory::all();
        $categories = Category::all();
        return view('admin.product.sub-category.create', compact('maincategories', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubCategoryCreateRequest $request)
    {
        $imagePath = $this->uploadImage($request, 'image', '', '/uploads');
        $subcategory = new SubCategory();
        $subcategory->name = $request->name;
        $subcategory->main_category_id = $request->main_category_id;
        $subcategory->category_id = $request->category_id;
        $subcategory->slug = generateUniqueSlug('SubCategory', $request->name);
        $subcategory->image = $imagePath;
        $subcategory->description = $request->description;
        $subcategory->seo_title = $request->seo_title;
        $subcategory->seo_description = $request->seo_description;
        $subcategory->status = $request->status;
        $subcategory->position = $request->position;
        $subcategory->save();
        toastr()->success('Product Sub Category Created Successfully');
        return to_route('admin.sub-category.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subcategory = SubCategory::findOrFail($id);
        return view('admin.product.sub-category.show', compact('subcategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $maincategories = MainCategory::all();
        $categories = Category::all();
        return view('admin.product.sub-category.edit', compact('subcategory', 'maincategories', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $this->removeImage($category->image);
            $category->delete();
            return response(['status' => 'success', 'message' => 'Product Category deleted successfully']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'Something went wrong']);

        }
    }

    public function getCategoriesByMainCategory(Request $request)
    {
        $categories = Category::where('main_category_id', $request->mainCategoryId)->get();
        return response()->json($categories);
    }
}
