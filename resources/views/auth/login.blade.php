@extends('layouts.app')

@section('content')
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #f3f4f6; padding: 3rem 1rem;">
        <div style="width: 100%; max-width: 28rem; background-color: white; padding: 2rem; border-radius: 0.75rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);">
            
            <div style="text-align: center;">
                <h2 style="font-size: 1.875rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem;">
                    Masuk ke Akun Anda
                </h2>
                <p style="font-size: 0.875rem; color: #4b5563;">
                    Masukkan email dan password untuk melanjutkan
                </p>
            </div>

            <form style="margin-top: 2rem;" action="{{ route('login.process') }}" method="POST">
                @csrf

                <!-- Email -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="email" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151;">
                        Email
                    </label>
                    <div style="margin-top: 0.25rem;">
                        <input 
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            required
                            placeholder="contoh@email.com"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; outline: none; transition: all 0.2s;"
                            onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.2)';"
                            onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';"
                        >
                    </div>
                    @error('email')
                        <p style="margin-top: 0.25rem; font-size: 0.875rem; color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password dengan show/hide -->
                <div style="margin-bottom: 1.5rem; position: relative;">
                    <label for="password" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151;">
                        Password
                    </label>
                    <div style="margin-top: 0.25rem; position: relative;">
                        <input 
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required
                            placeholder="••••••••"
                            style="width: 100%; padding: 0.75rem 2.5rem 0.75rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; outline: none; transition: all 0.2s;"
                            onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.2)';"
                            onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';"
                        >
                        <button 
                            type="button"
                            id="togglePassword"
                            style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 0; color: #6b7280;"
                        >
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 1.25rem; height: 1.25rem;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p style="margin-top: 0.25rem; font-size: 0.875rem; color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember me + Lupa password -->
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
                    <a href="#" style="font-size: 0.875rem; color: #6366f1; text-decoration: none;" 
                    onmouseover="this.style.color='#4f46e5'" 
                    onmouseout="this.style.color='#6366f1'">
                        Lupa password?
                    </a>
                </div>

                <!-- Tombol Login -->
                <button 
                    type="submit"
                    style="width: 100%; padding: 0.75rem; background-color: #6366f1; color: white; border: none; border-radius: 0.5rem; font-weight: 500; cursor: pointer; transition: background-color 0.2s;"
                    onmouseover="this.style.backgroundColor='#4f46e5'"
                    onmouseout="this.style.backgroundColor='#6366f1'"
                >
                    Masuk
                </button>

                <!-- Link Register -->
                <div style="text-align: center; margin-top: 1.5rem; font-size: 0.875rem; color: #4b5563;">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" style="color: #6366f1; font-weight: 500; text-decoration: none;"
                    onmouseover="this.style.color='#4f46e5'" 
                    onmouseout="this.style.color='#6366f1'">
                        Daftar sekarang
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function () {
            // toggle tipe input
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // ganti ikon (eye ↔ eye-slash)
            if (type === 'text') {
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                `;
            } else {
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        });
    </script>
@endsection