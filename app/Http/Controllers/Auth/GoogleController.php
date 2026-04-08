<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            
            // Cari user berdasarkan email, kalau ga ada langsung buat baru
            $findUser = User::updateOrCreate(
                ['email' => $user->email],
                [
                    'name' => $user->name,
                    'google_id' => $user->id,
                    'password' => bcrypt(Str::random(16)), // Password random buat keamanan
                    'email_verified_at' => now(),
                    'role' => 'user',
                ]
            );

            Auth::login($findUser);
            // Cek kalau ini user baru banget, bisa lempar ke profil buat lengkapi alamat
            if ($user->wasRecentlyCreated) {
                    return redirect()->route('user.account.profile')->with('success', 'Akun berhasil dibuat via Google!');
                }

            return redirect()->intended('/')->with('success', 'Berhasil masuk!');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Gagal registrasi lewat Google.');
        }
    }
}