<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BrandDataTable;
use App\Http\Controllers\Controller;
use App\Events\UrlRedirectCreateEvent;
use App\Http\Requests\Admin\BrandCreateRequest;
use App\Http\Requests\Admin\BrandUpdateRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
class BrandController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(BrandDataTable $dataTable)
    {
      return $dataTable->render('admin.product.brand.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandCreateRequest $request)
    {
        $logoPath = $this->uploadImage($request, 'logo', '', '/uploads/logos');
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->logo = $logoPath;
        $brand->description = $request->description;
        $brand->seo_title = $request->seo_title;
        $brand->seo_description = $request->seo_description;
        $brand->status = $request->status;
        $brand->position = $request->position;
        $brand->save();
        toastr()->success('Brand created successfully');
        return to_route('admin.brand.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.product.brand.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.product.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandUpdateRequest $request, string $id)

    {
        $brand = brand::findOrFail($id);
        $logoPath = $this->uploadImage($request, 'logo', $request->old_logo, '/uploads/logos');
        $brand->name = $request->name;
        // if create-url-redirect is checked
        if ($request->create_url_redirect) {
            $brand->slug = $request->new_slug;
        }
        else
        {
            $brand->slug = $request->old_slug;
        }
        // If no new image or logo is uploaded, keep the current path from the hidden input
        $brand->logo = $logoPath ?: $request->old_logo;
        $brand->description = $request->description;
        $brand->seo_title = $request->seo_title;
        $brand->seo_description = $request->seo_description;
        $brand->status = $request->status;
        $brand->position = $request->position;
        $brand->save();

        if ($request->create_url_redirect) {
            $from_url = $request->full_old_slug;
            $to_url = $request->full_new_slug;

            event(new UrlRedirectCreateEvent($from_url, $to_url));
        }

        toastr()->success('Brand updated successfully');
        return to_route('admin.brand.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $brand = brand::findOrFail($id);
            $this->removeImage($brand->logo);
            $brand->delete();
            return response(['status' => 'success', 'message' => 'Brand deleted successfully']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'Something went wrong']);

        }
    }
}
