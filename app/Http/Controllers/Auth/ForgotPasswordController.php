<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password; // Gunakan Facade ini
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    // 1. Tampilkan Form Input Email
    public function showLinkRequestForm() {
        return view('auth.forgot-password');
    }

    // 2. Proses Kirim Link Reset ke Email
    public function sendResetLinkEmail(Request $request) {
        $request->validate(['email' => 'required|email']);

        // Logika kirim link reset bawaan Laravel
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    // 3. Tampilkan Form Input Password Baru (dari Link Email)
    public function showResetForm($token) {
        return view('auth.reset-password')->with([
            'token' => $token, 
            'email' => request()->email
        ]);
    }

    // 4. Proses Update Password Baru
    public function reset(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}