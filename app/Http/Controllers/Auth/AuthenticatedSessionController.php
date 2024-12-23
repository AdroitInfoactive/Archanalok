<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\FooterInfo;
use App\Models\MainCategory;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $footerInfo = FooterInfo::first();
        $mainCategory = MainCategory::where('status', 1)
        ->orderBy('position', 'asc')
        ->get();
        return view('auth.login', compact('mainCategory', 'footerInfo'));
    }

    /**
     * Handle an incoming authentication request.
     */
  
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    // Check the user's status
    if ($request->user()->status === 'a') {
        if ($request->user()->role === 'admin') {
            return redirect()->intended(RouteServiceProvider::ADMIN);
        }
        return redirect()->intended(RouteServiceProvider::HOME);
    } elseif ($request->user()->status === 'p') {
        auth()->logout(); // Logout the user
    }
    auth()->logout();
    return redirect()->route('login')->withErrors(['status' => 'Your account is not active.']);
}


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
