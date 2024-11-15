<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReturnPolicy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReturnPolicyController extends Controller
{
    public function index()
    {
        $returnPolicy = ReturnPolicy::first();
        return view('admin.return-policy.index', compact('returnPolicy'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'content' => 'required',    
        ]);
        ReturnPolicy::updateOrCreate(
            ['id' => 1],
            [
              'content' => $request->content,
             ]
        );
        toastr()->success('Created Successfully');
        return redirect()->back();
    }
}
