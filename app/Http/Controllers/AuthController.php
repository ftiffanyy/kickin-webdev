<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class AuthController extends Controller
{
    // public function login(Request $request)
    // {
    //     $email = $request->input('email');
    //     $password = $request->input('password');

    //     if ($email === 'user@user.com' && $password === 'user') {
    //         session(['user_email' => $email, 'user_role' => 'User']);
    //         return redirect('/');
    //     } elseif ($email === 'admin@admin.com' && $password === 'admin') {
    //         session(['user_email' => $email, 'user_role' => 'Admin']);
    //         return redirect('/admin');
    //     } else {
    //         return back()->with('error', 'Invalid credentials');
    //     }
    // }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // return redirect()->intended('/');

            // Redirect based on role
            $user = Auth::user();
            if ($user->role === 'Admin') {
                return redirect()->route('dashboard_admin');  // Redirect Admin to the admin dashboard
            } else {
                return redirect()->route('dashboard');  // Redirect Customer to the customer dashboard
            }
        }

        return back()->with([
            'error' => 'The provided credentials do not match our records.',
        ]);
    }


    public function showForgotForm()
    {
        return view('auth.forget');
    }

    public function forgotPassword(Request $request)
    {
        // Just simulate success
        return back()->with('status', 'Password reset link has been sent (simulated).');
    }

    // public function register(Request $request) {
    //     session(['user_role' => 'User']);
    //     // bisa simpan data sementara di session / flash message
    //     return redirect()->route('dashboard');/*->with('status', 'Registered successfully. Please login.');*/
    // }

    public function register(Request $request)
    {
        // Register user logic (ensure you handle password hashing)
        // For simplicity, we will assign a default role for now
        $user = User::create([
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => 'User', // Default to User role
        ]);

        // Log the user in after registration
        Auth::login($user);
        
        return redirect()->route('dashboard'); // Or wherever you want
    }


     public function showAuth()
    {
        return view('auth.auth');
    }
}


// halo SENIN 26 MEI 2025 8.56