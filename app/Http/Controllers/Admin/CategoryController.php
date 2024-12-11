<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoryDataTable;
use App\Events\UrlRedirectCreateEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryCreateRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Models\Category;
use App\Models\MainCategory;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.product.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $maincategories = MainCategory::all();
        return view('admin.product.category.create', compact('maincategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryCreateRequest $request)
    {
        $imagePath = $this->uploadImage($request, 'image', '', '/uploads');
        $category = new Category();
        $category->name = $request->name;
        $category->main_category_id = $request->main_category_id;
        $category->slug = $request->slug;
        $category->image = $imagePath;
        $category->description = $request->description;
        $category->seo_title = $request->seo_title;
        $category->seo_description = $request->seo_description;
        $category->status = $request->status;
        $category->position = $request->position;
        $category->save();
        toastr()->success('Product Category Created Successfully');
        return to_route('admin.category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.product.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        $maincategories = MainCategory::all();
        return view('admin.product.category.edit', compact('category', 'maincategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id)
    {
        $category = Category::findOrFail($id);
        $imagePath = $this->uploadImage($request, 'image', $category->image, '/uploads');
        $category->name = $request->name;
        $category->main_category_id = $request->main_category_id;
        if ($request->create_url_redirect) {
            $category->slug = $request->new_slug;
        }
        else
        {
            $category->slug = $request->old_slug;
        }
        $category->image = $imagePath ?: $category->image;
        $category->description = $request->description;
        $category->seo_title = $request->seo_title;
        $category->seo_description = $request->seo_description;
        $category->status = $request->status;
        $category->position = $request->position;
        $category->save();

        if ($request->create_url_redirect) {
            $from_url = $request->full_old_slug;
            $to_url = $request->full_new_slug;

            event(new UrlRedirectCreateEvent($from_url, $to_url));
        }
        toastr()->success('Product Category Updated Successfully');
        return to_route('admin.category.index');
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
}
