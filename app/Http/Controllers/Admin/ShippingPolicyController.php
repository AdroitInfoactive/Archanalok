<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingPolicy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ShippingPolicyController extends Controller
{
    public function index()
    {
        $shippingPolicy=ShippingPolicy::first();
        return view('admin.shipping-policy.index', compact('shippingPolicy'));
    }
    function update(Request $request): RedirectResponse
    {
        $request->validate([
            'content' => 'required',    
        ]);
       

        ShippingPolicy::updateOrCreate(
            ['id' => 1],
            [
              'content' => $request->content,
             ]
        );
       

        toastr()->success('Created Successfully');

        return redirect()->back();
    }
}
