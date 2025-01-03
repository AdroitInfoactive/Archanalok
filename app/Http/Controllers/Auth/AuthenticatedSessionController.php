<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\FooterInfo;
use App\Models\MainCategory;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends BaseController
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
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
            $msg='Your account is pending for approval, Please contact administrator.';
            auth()->logout(); // Logout the user
        }
        elseif ($request->user()->status === 'i') {
            $msg='Your account is inactive, Please contact administrator.';
            auth()->logout(); // Logout the user
        }
        elseif ($request->user()->status === 'r') {
            $msg='Your account is rejected, Please contact administrator.';
            auth()->logout(); // Logout the user
            
        }
        auth()->logout();
        return redirect()->route('login')->withErrors(['status' => $msg]);
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
