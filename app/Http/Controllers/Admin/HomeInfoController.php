<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HomeInfoUpdateRequest;
use App\Models\HomeInfo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
class HomeInfoController extends Controller
{
    function index(): View
    {
        $homeInfo = HomeInfo::first();
        return view('admin.home-info.index', compact('homeInfo'));
    }

    function update(HomeInfoUpdateRequest $request): RedirectResponse
    {

        HomeInfo::updateOrCreate(
            ['id' => 1],
            [
                'title' => $request->title,
                'description' => $request->description,
                'short_description' => $request->short_description,
                'url' => $request->url
            ]
        );

        toastr()->success('Created Successfully');

        return redirect()->back();
    }
   
}
