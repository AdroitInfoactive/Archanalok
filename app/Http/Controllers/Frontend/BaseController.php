<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MainCategory;
use App\Models\FooterInfo;
use Illuminate\View\View;

class BaseController extends Controller
{
    protected $mainCategory;
    protected $footerInfo;

    public function __construct()
    {
        $this->mainCategory = MainCategory::where('status', 1)
            ->orderBy('position', 'asc')
            ->get();

        $this->footerInfo = FooterInfo::first();

        // Share these variables with all views
        view()->share([
            'mainCategory' => $this->mainCategory,
            'footerInfo' => $this->footerInfo,
        ]);
    }
}
