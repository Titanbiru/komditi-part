@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center font-['DM_Sans'] px-4 py-12">
    <div class="w-full max-w-md bg-[#FEFEFE] p-8 md:p-10 rounded-[2.5rem] shadow-xl shadow-black/5 border-2 border-[#BABABA]/10">
        
        {{-- Header --}}
        <div class="text-center mb-10">
            <h2 class="text-3xl font-black text-[#202020] tracking-tighter uppercase">
                Selamat Datang
            </h2>
            <p class="text-xs font-bold text-[#BABABA] uppercase tracking-widest mt-2">
                Silahkan masuk ke akun anda
            </p>
        </div>

        <form action="{{ route('login.process') }}" method="POST" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <label for="email" class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#202020] ml-1">
                    Email Address
                </label>
                <input 
                    id="email" name="email" type="email" required 
                    value="{{ old('email') }}"
                    placeholder="contoh@email.com"
                    class="w-full px-5 py-4 bg-[#F9F9F9] border-2 border-transparent rounded-2xl text-sm font-bold text-[#202020] placeholder-[#BABABA] focus:bg-white focus:border-[#1BCFD5] focus:ring-4 focus:ring-[#1BCFD5]/10 outline-none transition-all duration-200"
                >
                @error('email')
                    <p class="text-[10px] font-bold text-[#CD2828] mt-1 ml-1 uppercase tracking-wider">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <div class="flex justify-between items-center px-1">
                    <label for="password" class="text-[10px] font-black uppercase tracking-[0.2em] text-[#202020]">
                        Password
                    </label>
                    <a href="{{ route('password.request') }}" class="text-[10px] font-black uppercase tracking-widest text-[#CD2828] ...">
                        Lupa?
                    </a>
                </div>
                <div class="relative group">
                    <input 
                        id="password" name="password" type="password" required 
                        placeholder="••••••••"
                        class="w-full px-5 py-4 bg-[#F9F9F9] border-2 border-transparent rounded-2xl text-sm font-bold text-[#202020] placeholder-[#BABABA] focus:bg-white focus:border-[#1BCFD5] focus:ring-4 focus:ring-[#1BCFD5]/10 outline-none transition-all duration-200"
                    >
                    <button type="button" id="togglePassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#BABABA] hover:text-[#1BCFD5] transition-colors p-1">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-[10px] font-bold text-[#CD2828] mt-1 ml-1 uppercase tracking-wider">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4">
                <button 
                    type="submit" 
                    class="w-full bg-[#CD2828] text-[#FEFEFE] py-5 rounded-2xl font-black text-[11px] uppercase tracking-[0.25em] shadow-lg shadow-[#CD2828]/20 hover:bg-[#832A2A] hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200"
                >
                    Sign In
                </button>
            </div>

            <div class="relative flex py-5 items-center">
                <div class="flex-grow border-t border-[#BABABA]/20"></div>
                <span class="flex-shrink mx-4 text-[10px] font-black text-[#BABABA] uppercase tracking-widest">Atau</span>
                <div class="flex-grow border-t border-[#BABABA]/20"></div>
            </div>

            <a href="{{ route('google.login') }}" class="w-full bg-white border-2 border-black py-4 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] flex items-center justify-center gap-3 hover:bg-gray-50 transition-all">
                <img src="https://www.gstatic.com/firebase/explore/secondary-login/google.svg" class="w-5 h-5">
                Continue with Google
            </a>

            <div class="text-center mt-6 pt-6 border-t border-[#BABABA]/10">
                <p class="text-[11px] font-bold text-[#BABABA] uppercase tracking-wider">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-[#CD2828] hover:text-[#1BCFD5] transition-colors ml-1 font-black underline decoration-2 underline-offset-4">
                        Daftar Sekarang
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        if (type === 'text') {
            eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />`;
        } else {
            eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
        }
    });
</script>
@endsection