@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-[#CD2828]">Add New Staff</h1>
        <a href="{{ route('admin.users.index') }}" 
           class="px-6 py-2 bg-gray-200 text-gray-800 rounded-full font-medium hover:bg-gray-300 transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-[#BABABA] p-8">
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}" 
                           required 
                           class="w-full border border-[#BABABA] rounded-lg px-4 py-3 focus:outline-none focus:border-[#CD2828]">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email/Username</label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email') }}" 
                           required 
                           class="w-full border border-[#BABABA] rounded-lg px-4 py-3 focus:outline-none focus:border-[#CD2828]">
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">No Telephone</label>
                    <input type="text" 
                           name="phone" 
                           id="phone" 
                           value="{{ old('phone') }}" 
                           class="w-full border border-[#BABABA] rounded-lg px-4 py-3 focus:outline-none focus:border-[#CD2828]" 
                           placeholder="Masukkan nomor telepon (opsional)">
                    @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           required 
                           class="w-full border border-[#BABABA] rounded-lg px-4 py-3 focus:outline-none focus:border-[#CD2828]">
                    @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <input type="password" 
                           name="password_confirmation" 
                           id="password_confirmation" 
                           required 
                           class="w-full border border-[#BABABA] rounded-lg px-4 py-3 focus:outline-none focus:border-[#CD2828]">
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-10">
                <a href="{{ route('admin.users.index') }}" 
                    class="px-8 py-3 bg-gray-200 text-gray-800 rounded-full font-medium hover:bg-gray-300 transition-colors">
                    Kembali
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-[#CD2828] text-white rounded-full font-medium hover:bg-[#832A2A] transition-colors">
                    Simpan Staff Baru
                </button>
            </div>
        </form>
    </div>
@endsection