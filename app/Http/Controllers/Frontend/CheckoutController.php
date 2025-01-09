<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Cart;
use Illuminate\Http\Request;

class CheckoutController extends BaseController
{
    public function index()
    {
        if (Cart::count() == 0) {
            return redirect()->route('cart.index');
        }
        return view('frontend.checkout.index');
    }
}
