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
    public function showAuth()
    {
        return view('auth.auth');
    }
    
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

        return back()->with('error', 'Email or password not found. Please try again');
    }


    public function showForgotForm()
    {
        return view('auth.forget');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Generate 6-digit OTP
        $otp = rand(100000, 999999);

        // Save OTP to database
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $otp, 'created_at' => now()]
        );

        // Send OTP to user's email
        Mail::to($request->email)->send(new VerificationCodeMail($otp));

        // // Return success message to the view
        // return back()->with('status', 'OTP has been sent to your email.');

        // Store email in session to use later for password reset
        session(['email' => $request->email]);

        // Redirect to OTP page with a success message
        return redirect()->route('otp.form')->with('status', 'OTP has been sent to your email.');
    }

    // Show OTP form
    public function showOtpForm()
    {
        return view('auth.otp');
    }

    // Handle OTP verification
    // public function verifyOtp(Request $request)
    // {
    //     $request->validate([
    //         'otp' => 'required|numeric',
    //     ]);

    //     // Get OTP from the session or database
    //     $email = session('email');  // Assuming you stored the email in session when sending OTP
    //     $otp = DB::table('password_resets')->where('email', $email)->first()->token;

    //     if ($request->otp == $otp) {
    //         // Pass the email as a parameter when redirecting to the password reset page
    //         return redirect()->route('password.reset.form', ['email' => $email]);
    //     }

    //     return back()->with('status', 'Invalid OTP. Please try again.');
    // }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp1' => 'required|numeric',
            'otp2' => 'required|numeric',
            'otp3' => 'required|numeric',
            'otp4' => 'required|numeric',
            'otp5' => 'required|numeric',
            'otp6' => 'required|numeric',
        ]);

        // Combine the OTP fields into one string
        $otp = $request->otp1 . $request->otp2 . $request->otp3 . $request->otp4 . $request->otp5 . $request->otp6;

        $email = session('email');  // Retrieve the email from session

        // Get the OTP stored in the database
        $storedOtp = DB::table('password_resets')->where('email', $email)->first()->token;

        if ($otp == $storedOtp) {
            return redirect()->route('password.reset.form', ['email' => $email]);
        }

        return back()->with('status', 'Invalid OTP. Please try again.');
    }

    public function resendOtp(Request $request)
    {
        $email = session('email');  // Retrieve the email from the session

        // Validate email exists in password_resets table
        $reset = DB::table('password_resets')->where('email', $email)->first();

        if ($reset) {
            // Generate new 6-digit OTP
            $otp = rand(100000, 999999);

            // Update OTP in the database
            DB::table('password_resets')->where('email', $email)->update(['token' => $otp, 'created_at' => now()]);

            // Send the new OTP to the user's email
            Mail::to($email)->send(new VerificationCodeMail($otp));

            return back()->with('status', 'A new OTP has been sent to your email.');
        }

        return back()->with('status', 'OTP request has expired. Please request a new one.');
    }

    // Show password reset form
    public function showResetPasswordForm($email)
    {
        // $email = session('email');  // Retrieve email from the session
        return view('auth.reset', compact('email'));
    }

    // Handle password reset
    public function updatePassword(Request $request, $email)
    {
        $request->validate([
            'new_password' => 'required|string',
        ]);

        // $email = session('email');  // Get email from session
        DB::table('users')->where('email', $email)->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Delete OTP entry after successful password reset
        DB::table('password_resets')->where('email', $email)->delete();

        return redirect('/auth')->with('status', 'Password has been reset successfully. Please login.');
    }

    // // Function baru untuk memproses reset password
    // public function resetPassword(Request $request)
    // {
    //     $request->validate([
    //         'token' => 'required',
    //         'email' => 'required|email',
    //         'password' => 'required|min:8|confirmed',
    //     ], [
    //         'password.required' => 'Password is required.',
    //         'password.min' => 'Password must be at least 8 characters.',
    //         'password.confirmed' => 'Password confirmation does not match.',
    //     ]);

    //     try {
    //         $status = Password::reset(
    //             $request->only('email', 'password', 'password_confirmation', 'token'),
    //             function (User $user, string $password) {
    //                 $user->forceFill([
    //                     'password' => Hash::make($password)
    //                 ])->setRememberToken(Str::random(60));

    //                 $user->save();

    //                 event(new PasswordReset($user));
    //             }
    //         );

    //         if ($status === Password::PASSWORD_RESET) {
    //             return redirect()->route('auth')->with('status', 'Your password has been reset successfully. Please login with your new password.');
    //         } else {
    //             return back()->withErrors(['email' => [__($status)]]);
    //         }
    //     } catch (\Exception $e) {
    //         Log::error('Password reset error: ' . $e->getMessage());
    //         return back()->withErrors(['email' => 'An error occurred. Please try again later.']);
    //     }
    // }

    // public function verifyCode(Request $request)
    // {
    //     // Validasi kode verifikasi
    //     $request->validate([
    //         'verification_code' => 'required|numeric|digits:6',
    //     ]);

    //     // Cek kode verifikasi di tabel password_resets
    //     $reset = DB::table('password_resets')
    //                 ->where('token', $request->verification_code)
    //                 ->first();

    //     if (!$reset) {
    //         return back()->withErrors(['verification_code' => 'Invalid verification code.']);
    //     }

    //     // Kode valid, arahkan ke halaman reset password
    //     return redirect()->route('password.reset.form', ['email' => $reset->email]);
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
}


// halo SENIN 26 MEI 2025 8.56