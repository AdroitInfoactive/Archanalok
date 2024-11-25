<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BannerSlider;
use App\Models\Counter;
use App\Models\FooterInfo;
use App\Models\HomeInfo;
use App\Models\Subscriber;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mail;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $bannerSliders = BannerSlider::where('status', 1)->orderBy('position', 'asc')->get();
        $homeInfo=HomeInfo::first();
        $counter=Counter::first();
        $footerInfo=FooterInfo::first();
        return view('frontend.home.index', compact('bannerSliders','homeInfo','counter','footerInfo'));
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
        //
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
        //
    }
    function subscribeNewsletter(Request $request) : Response
{
    $request->validate([
        'email' => ['required', 'email', 'max:255', 'unique:subscribers,email']
    ], ['email.unique' => 'Email is already subscribed!']);

    $subscriber = new Subscriber();
    $subscriber->email = $request->email;
    $subscriber->save();

    return response(['status' => 'success', 'message' => 'Subscribed Successfully!']);
}
}
