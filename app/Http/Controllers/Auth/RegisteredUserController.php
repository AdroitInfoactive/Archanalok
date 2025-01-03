<?php

namespace App\Http\Controllers\Auth;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\BaseController;
use App\Mail\UserActivatedMail;
use App\Models\FooterInfo;
use App\Models\MainCategory;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Mail;

class RegisteredUserController extends BaseController
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'user_type' => ['required'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    
        $status = ($request->user_type === 'ws' || $request->user_type === 'dr') ? 'p' : 'a';
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->user_type,
            'password' => Hash::make($request->password),
            'status' => $status, // Adding the status based on user_type
        ]);
    
        event(new Registered($user));
    
        Auth::login($user);
    
        // Check the user's status after registration
        if ($user->status === 'p') {
            auth()->logout();
            toastr()->error('Your account is awaiting approval. Please wait for admin approval.');
            return redirect()->route('home'); // Redirect to home page or dashboard
        }
    
        // Redirect to home/dashboard for approved users
        return redirect(RouteServiceProvider::HOME);
    }
    public function userDetails(UserDataTable $dataTable)
    {
        return $dataTable->render('admin.user.index');
    }
    
    public function updateStatus(Request $request)
    {
        $user = User::find($request->id);
    
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found']);
        }
    
        $user->status = $request->status;
        $user->save();
    
        // Send email if status is set to 'active'
        if ($user->status == 'a') { // Assuming 'a' stands for 'active'
            Mail::to($user->email)->send(new UserActivatedMail($user));
        }
    
        return response()->json(['success' => true, 'message' => 'User Status updated successfully']);
    }

    
    
}
