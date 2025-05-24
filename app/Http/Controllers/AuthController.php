<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if ($email === 'user@user.com' && $password === 'user') {
            session(['user_email' => $email, 'user_role' => 'User']);
            return redirect('/');
        } elseif ($email === 'admin@admin.com' && $password === 'admin') {
            session(['user_email' => $email, 'user_role' => 'Admin']);
            return redirect('/admin');
        } else {
            return back()->with('error', 'Invalid credentials');
        }
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

    public function register(Request $request) {
        session(['user_role' => 'User']);
        // bisa simpan data sementara di session / flash message
        return redirect()->route('dashboard');/*->with('status', 'Registered successfully. Please login.');*/
    }

     public function showAuth()
    {
        return view('auth.auth');
    }
}


// halo jevon seksi