{{-- resources/views/auth/forgot-password.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white p-10 rounded-[2.5rem] border-2 border-[#BABABA]/10 shadow-xl">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-black text-[#202020] uppercase tracking-tighter">Minta Link Reset</h2>
            <p class="text-xs font-bold text-[#BABABA] uppercase tracking-widest mt-2">Masukan email untuk mendapatkan token</p>
        </div>

        @if (session('status'))
            <div class="mb-6 p-4 bg-green-50 border-2 border-green-500 rounded-2xl text-[10px] font-black uppercase text-green-600 text-center">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
            @csrf
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest">Email Address</label>
                <input type="email" name="email" required class="w-full px-5 py-4 bg-[#F9F9F9] border-2 border-transparent rounded-2xl outline-none focus:border-[#CD2828]">
            </div>
            <button type="submit" class="w-full bg-[#202020] text-white py-5 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] hover:bg-[#CD2828] transition-all">
                Kirim Token ke Email
            </button>
        </form>
    </div>
</div>
@endsection