<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\UserCart;
use Illuminate\Http\Request;
use App\Models\MainCategory;
use App\Models\FooterInfo;
use Illuminate\View\View;

class BaseController extends Controller
{
    protected $mainCategory;
    protected $footerInfo;
    protected $cartDetails;

    public function __construct()
    {
        $this->mainCategory = MainCategory::where('status', 1)
            ->orderBy('position', 'asc')
            ->get();

        $this->footerInfo = FooterInfo::first();

        // Share common data that doesn't depend on authentication
        view()->share([
            'mainCategory' => $this->mainCategory,
            'footerInfo' => $this->footerInfo,
        ]);

        // Use middleware for auth-dependent logic
        $this->middleware(function ($request, $next) {
            if (auth()->check()) {
                $this->cartDetails = UserCart::where('user_id', auth()->user()->id)->get();
                view()->share('cartDetails', $this->cartDetails);
            } else {
                view()->share('cartDetails', []);
            }

            return $next($request);
        });
    }
}
