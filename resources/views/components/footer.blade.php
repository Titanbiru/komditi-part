
<footer class="bg-[#cd2828] text-[#FEFEFE]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">

            {{-- Kolom 1: Alamat + Jam Operasional --}}
            <div>
                <div class="flex items-center gap-4 mb-8">
                    <span class="text-4xl font-extrabold tracking-tight text-[#fefefe]">Komditi Part</span>
                </div>

                <div class="flex gap-4 text-base leading-relaxed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mt-1 flex-shrink-0 text-[#fefefe]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <div>
                        Ruko Mangga Dua Square, Jl. Gn. Sahari<br>
                        No.1 Blok A, No. 8, Ancol, Kec. Pademangan,<br>
                        Jkt Utara, Daerah Khusus Ibukota Jakarta 14420
                    </div>
                </div>

                <div class="flex gap-4 mt-6 text-base leading-relaxed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mt-1 flex-shrink-0 text-[#fefefe]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        Operasional:<br>
                        Senin – Sabtu 09:00 – 18:30 WIB<br>
                        Minggu 09:00 – 16:30 WIB
                    </div>
                </div>
            </div>

            {{-- Kolom 2: Akun & Kontak --}}
            <div class="md:text-center">
                <h3 class="font-bold text-xl mb-6 tracking-wide text-[#fefefe]">Akun dan Kontak</h3>
                <div class="space-y-4 text-base">
                    <div class="">
                        <a href="{{ route('login') }}" class="hover:text-[#832a2a] transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="hover:text-[#832a2a] transition-colors">Register</a>
                    </div>
                    <a href="{{ route('contact.index') }}" class="block hover:text-[#832a2a] transition-colors">Contact Us</a>
                </div>
            </div>

            {{-- Kolom 3: Sosial Media --}}
            <div class="md:text-right">
                <h3 class="font-bold text-xl mb-6 tracking-wide text-[#fefefe]">Sosial Media Kami</h3>
                <div class="flex gap-8 md:justify-end">
                    {{-- WhatsApp --}}
                    <a href="#" class="text-[#FEFEFE] hover:text-[#832a2a] transition-colors transform hover:scale-110 duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19.05 4.91A9.82 9.82 0 0 0 12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01m-7.01 15.24c-1.48 0-2.93-.4-4.2-1.15l-.3-.18l-3.12.82l.83-3.04l-.2-.31a8.26 8.26 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24c2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.83c.02 4.54-3.68 8.23-8.22 8.23m4.52-6.16c-.25-.12-1.47-.72-1.69-.81c-.23-.08-.39-.12-.56.12c-.17.25-.64.81-.78.97c-.14.17-.29.19-.54.06c-.25-.12-1.05-.39-1.99-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.14-.25-.02-.38.11-.51c.11-.11.25-.29.37-.43s.17-.25.25-.41c.08-.17.04-.31-.02-.43s-.56-1.34-.76-1.84c-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31c-.22.25-.86.85-.86 2.07s.89 2.4 1.01 2.56c.12.17 1.75 2.67 4.23 3.74c.59.26 1.05.41 1.41.52c.59.19 1.13.16 1.56.1c.48-.07 1.47-.6 1.67-1.18c.21-.58.21-1.07.14-1.18s-.22-.16-.47-.28"/></svg>
                    </a>

                    {{-- TikTok --}}
                    <a href="#" class="text-[#FEFEFE] hover:text-[#832a2a] transition-colors transform hover:scale-110 duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M16.6 5.82s.51.5 0 0A4.28 4.28 0 0 1 15.54 3h-3.09v12.4a2.59 2.59 0 0 1-2.59 2.5c-1.42 0-2.6-1.16-2.6-2.6c0-1.72 1.66-3.01 3.37-2.48V9.66c-3.45-.46-6.47 2.22-6.47 5.64c0 3.33 2.76 5.7 5.69 5.7c3.14 0 5.69-2.55 5.69-5.7V9.01a7.35 7.35 0 0 0 4.3 1.38V7.3s-1.88.09-3.24-1.48"/></svg>
                    </a>

                    {{-- Instagram --}}
                    <a href="#" class="text-[#FEFEFE] hover:text-[#832a2a] transition-colors transform hover:scale-110 duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none"><path stroke="currentColor" stroke-width="2" d="M3 11c0-3.771 0-5.657 1.172-6.828S7.229 3 11 3h2c3.771 0 5.657 0 6.828 1.172S21 7.229 21 11v2c0 3.771 0 5.657-1.172 6.828S16.771 21 13 21h-2c-3.771 0-5.657 0-6.828-1.172S3 16.771 3 13z"/><circle cx="16.5" cy="7.5" r="1.5" fill="currentColor"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></g></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Copyright --}}
    <div class="border-t border-[#832A2A]/50 bg-[#1a1a1a]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-sm opacity-80">
            © 2026. All rights reserved by Komditi Part / Tristan Prayogo
        </div>
    </div>
</footer>