<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use App\Models\MainCategoryBanner;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
class MainCategoryBannerController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $maincategory = MainCategory::findOrFail($id);
        $images=MainCategoryBanner::where('main_category_id', $id)->get();
        return view('admin.product.main-category.banner.index', compact('maincategory', 'images'));
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5000',
            'main_category_id' => 'required|integer',
            'title' => 'required',
            'sub_title' => 'nullable',
            'url' => 'nullable',
            'description' => 'nullable',
            'position' => 'required'
          
        ]);
        $imagePath = $this->uploadImage($request, 'image', '', '/uploads/main-cat-banner');
        $banner = new MainCategoryBanner();
        $banner->main_category_id = $request->main_category_id;
        $banner->image = $imagePath;
        $banner->title = $request->title;
        $banner->sub_title = $request->sub_title;
        $banner->url = $request->url;
        $banner->description = $request->description;
        $banner->position = $request->position;
        $banner->status =1;
        $banner->save();
        toastr()->success('Product Main Category Banner Added Successfully');
        return redirect()->back();
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
            $image = MainCategoryBanner::findOrFail($id);
            $this->removeImage($image->image);
            $image->delete();
            return response(['status' => 'success', 'message' => 'Product Main Category Banner Deleted Successfully']);

        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'Something went wrong']);
        }
    
    }
}
