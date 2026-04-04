<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->letters()->numbers()
            ]
        ]);

        $user = User::create([
            'name' => trim($validated['name']),
            'email' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
            'role' => 'user' 
        ]);

        Auth::login($user);

        return redirect()->route('public.index')->with('success', 'Registration successful! Welcome to Komditi Part.');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 1. Coba login dulu
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ]);
        }

        // 2. Ambil data user yang berhasil login
        $user = Auth::user();

        // 3. CEK APAKAH USER AKTIF?
        if (!$user->is_active) {
            Auth::logout(); // Paksa keluar lagi kalau statusnya non-aktif
            
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Akun Anda telah dinonaktifkan oleh Admin. Silakan hubungi dukungan.',
            ]);
        }

        // 4. Jika aktif, baru buat session
        $request->session()->regenerate();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'staff' => redirect()->route('staff.dashboard'),
            default => redirect()->route('public.index'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('public.index');
    }
}