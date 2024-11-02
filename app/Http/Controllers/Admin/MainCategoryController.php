<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\MainCategoryDataTable;
use App\Events\UrlRedirectCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MainCategoryCreateRequest;
use App\Http\Requests\Admin\MainCategoryUpdateRequest;
use App\Models\MainCategory;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class MainCategoryController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(MainCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.product.main-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.main-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MainCategoryCreateRequest $request)
    {
        $imagePath = $this->uploadImage($request, 'image', '', '/uploads');
        $logoPath = $this->uploadImage($request, 'logo', '', '/uploads/logos');
        $mainCategory = new MainCategory();
        $mainCategory->name = $request->name;
        $mainCategory->slug = $request->slug;
        $mainCategory->image = $imagePath;
        $mainCategory->logo = $logoPath;
        $mainCategory->description = $request->description;
        $mainCategory->seo_title = $request->seo_title;
        $mainCategory->seo_description = $request->seo_description;
        $mainCategory->status = $request->status;
        $mainCategory->position = $request->position;
        $mainCategory->save();
        toastr()->success('Product Main Category created successfully');
        return to_route('admin.main-category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $maincategory = MainCategory::findOrFail($id);
        return view('admin.product.main-category.show', compact('maincategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $maincategory = MainCategory::findOrFail($id);
        return view('admin.product.main-category.edit', compact('maincategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MainCategoryUpdateRequest $request, string $id)
    {
        $mainCategory = MainCategory::findOrFail($id);
        // Use uploadImage to handle new file uploads and deletion of old files if new ones are provided
        $imagePath = $this->uploadImage($request, 'image', $request->old_image, '/uploads');
        $logoPath = $this->uploadImage($request, 'logo', $request->old_logo, '/uploads/logos');
        $mainCategory->name = $request->name;
        // if create-url-redirect is checked
        if ($request->create_url_redirect) {
            $mainCategory->slug = $request->slug;
        }
        else
        {
            $mainCategory->slug = $request->old_slug;
        }
        // If no new image or logo is uploaded, keep the current path from the hidden input
        $mainCategory->image = $imagePath ?: $request->old_image;
        $mainCategory->logo = $logoPath ?: $request->old_logo;
        $mainCategory->description = $request->description;
        $mainCategory->seo_title = $request->seo_title;
        $mainCategory->seo_description = $request->seo_description;
        $mainCategory->status = $request->status;
        $mainCategory->position = $request->position;

        $mainCategory->save();

        if ($request->create_url_redirect) {
            $newUrl = $request->slug;
            $oldUrl = $request->old_slug;

            // Dispatch the event to save the URL redirect
            event(new UrlRedirectCreated($oldUrl, $newUrl));
        }

        toastr()->success('Product Main Category updated successfully');
        return to_route('admin.main-category.index');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $mainCategory = MainCategory::findOrFail($id);
            $this->removeImage($mainCategory->logo);
            $this->removeImage($mainCategory->image);
            $mainCategory->delete();
            return response(['status' => 'success', 'message' => 'Product Main Category deleted successfully']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'Something went wrong']);

        }
    }
}
