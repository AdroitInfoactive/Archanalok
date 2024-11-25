<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TermsAndCondition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TermsAndCoditionController extends Controller
{
    public function index()
    {
        $termsAndConditions = TermsAndCondition::first();
        return view('admin.terms-and-conditions.index', compact('termsAndConditions'));
    }
    function update(Request $request): RedirectResponse
    {
        $request->validate([
            'content' => 'required',    
        ]);
       

        TermsAndCondition::updateOrCreate(
            ['id' => 1],
            [
              'content' => $request->content,
             ]
        );

        toastr()->success('Created Successfully');

        return redirect()->back();
    }
}
