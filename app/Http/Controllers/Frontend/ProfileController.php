<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProfilePasswordUpdateRequest;
use App\Http\Requests\Frontend\ProfileUpdateRequest;
use App\Models\FooterInfo;
use App\Models\MainCategory;
use App\Traits\FileUploadTrait;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProfileController extends BaseController
{
    use FileUploadTrait;

    function profile() : View {
        $user = auth()->user();
        return view('frontend.dashboard.sections.personal-info-section', compact('user'));
    }
    function updateProfile(ProfileUpdateRequest $request) : RedirectResponse {
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        toastr()->success('Profile Updated Successfully');

        return redirect()->back();
    }

    function updatePassword(ProfilePasswordUpdateRequest $request) : RedirectResponse {
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();
        toastr()->success('Password Updated Successfully');

        return redirect()->back();
    }

    function updateAvatar(Request $request) {
        /** handle image file */
        $imagePath = $this->uploadImage($request, 'avatar', $oldPath = NULL, '/uploads');

        $user = Auth::user();
        $user->avatar = $imagePath;
        $user->save();

        return response(['status' => 'success', 'message' => 'Avatar Updated Successfully']);
    }
}
