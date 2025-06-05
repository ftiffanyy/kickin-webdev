<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

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

            // Redirect based on role
            $user = Auth::user();

            // Store the role and username (or name) in the session
            session(['user_role' => $user->role, 'username' => $user->name, 'user_id' => $user->id]);  // or $user->email if preferred

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
        // Validasi email
    $request->validate([
        'email' => 'required|email|exists:users,email',
    ], [
        'email.required' => 'Email address is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.exists' => 'Email address is not registered in our system.',
    ]);

    try {
        // Debugging point
        dd('Starting to generate verification code for email: ' . $request->email);

        // Generate 6-digit verification code
        $verificationCode = rand(100000, 999999);

        // Simpan kode verifikasi ke database atau password_resets (tabel yang sesuai)
        DB::table('password_resets')->where('email', $request->email)->delete();  // Hapus jika ada sebelumnya
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $verificationCode,
            'created_at' => now(),
        ]);

        // Debugging point
        dd('Verification code generated and saved to database.');

        // Kirimkan email dengan kode verifikasi
        Mail::to($request->email)->send(new VerificationCodeMail($verificationCode));

        // Kirimkan reset link
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Handle status setelah reset link dikirim
        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', 'Password reset link has been sent to your email address. Please check your inbox.');
        } else {
            switch ($status) {
                case Password::INVALID_USER:
                    return back()->withErrors(['email' => 'Email address is not registered.']);
                case Password::RESET_THROTTLED:
                    return back()->withErrors(['email' => 'Please wait before requesting another reset link.']);
                default:
                    return back()->withErrors(['email' => 'Unable to send reset link. Please try again later.']);
            }
        }
    } catch (\Exception $e) {
        Log::error('Password reset error: ' . $e->getMessage());
        return back()->withErrors(['email' => 'An error occurred. Please try again later.']);
    }
    }

    // Function baru untuk menampilkan form reset password
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    // Function baru untuk memproses reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        try {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                return redirect()->route('auth')->with('status', 'Your password has been reset successfully. Please login with your new password.');
            } else {
                return back()->withErrors(['email' => [__($status)]]);
            }
        } catch (\Exception $e) {
            Log::error('Password reset error: ' . $e->getMessage());
            return back()->withErrors(['email' => 'An error occurred. Please try again later.']);
        }
    }

    public function verifyCode(Request $request)
    {
        // Validasi kode verifikasi
        $request->validate([
            'verification_code' => 'required|numeric|digits:6',
        ]);

        // Cek kode verifikasi di tabel password_resets
        $reset = DB::table('password_resets')
                    ->where('token', $request->verification_code)
                    ->first();

        if (!$reset) {
            return back()->withErrors(['verification_code' => 'Invalid verification code.']);
        }

        // Kode valid, arahkan ke halaman reset password
        return redirect()->route('password.reset.form', ['email' => $reset->email]);
    }


    // public function register(Request $request) {
    //     session(['user_role' => 'User']);
    //     // bisa simpan data sementara di session / flash message
    //     return redirect()->route('dashboard');/*->with('status', 'Registered successfully. Please login.');*/
    // }

    public function register(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|regex:/^[0-9]+$/|min:10|max:15',
            'password' => 'required|string',
        ], [
            'phone.regex' => 'Phone number must contain only numbers.',
            'phone.min' => 'Phone number must be at least 10 digits.',
            'phone.max' => 'Phone number must not exceed 15 digits.',
        ]);
        

        // Create new user
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => bcrypt($request->input('password')),
            'role' => 'Customer', // Fixed role as Customer
        ]);

        // Log the user in after registration
        Auth::login($user);

        // Store role and username in session after registration
        session(['user_role' => $user->role, 'username' => $user->name]);
        
        return redirect()->route('dashboard'); // Or wherever you want
    }


     public function showAuth()
    {
        return view('auth.auth');
    }
}


// halo SENIN 26 MEI 2025 8.56