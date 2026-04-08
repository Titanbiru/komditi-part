{{-- resources/views/auth/reset-password.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white p-10 rounded-[2.5rem] border-2 border-[#BABABA]/10 shadow-xl">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-black text-[#202020] uppercase tracking-tighter">Reset Password</h2>
        </div>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
            @csrf
            {{-- VARIABEL TOKEN DITARUH DI HIDDEN INPUT --}}
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest">Email</label>
                <input type="email" name="email" value="{{ $email ?? old('email') }}" required readonly class="w-full px-5 py-4 bg-gray-100 rounded-2xl">
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest">Password Baru</label>
                <input type="password" name="password" required class="w-full px-5 py-4 bg-[#F9F9F9] border-2 border-transparent rounded-2xl focus:border-[#CD2828] outline-none">
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required class="w-full px-5 py-4 bg-[#F9F9F9] border-2 border-transparent rounded-2xl focus:border-[#CD2828] outline-none">
            </div>

            <button type="submit" class="w-full bg-[#CD2828] text-white py-5 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] hover:bg-black transition-all">
                Update Password
            </button>
        </form>
    </div>
</div>
@endsection