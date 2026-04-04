@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-[#CD2828]">Edit Staff: {{ $user->name }}</h1>
        <a href="{{ route('admin.users.index') }}" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-full font-medium hover:bg-gray-300 transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-[#BABABA] p-8">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required 
                            class="w-full border border-[#BABABA] rounded-lg px-4 py-3 focus:outline-none focus:border-[#CD2828] focus:ring-1 focus:ring-[#CD2828]">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email/Username</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required 
                            class="w-full border border-[#BABABA] rounded-lg px-4 py-3 focus:outline-none focus:border-[#CD2828] focus:ring-1 focus:ring-[#CD2828]">
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">No Telephone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" 
                            class="w-full border border-[#BABABA] rounded-lg px-4 py-3 focus:outline-none focus:border-[#CD2828] focus:ring-1 focus:ring-[#CD2828]" 
                            placeholder="Masukkan nomor telepon (opsional)">
                    @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Password opsional saat edit -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru (kosongkan jika tidak ingin ubah)</label>
                    <input type="password" name="password" id="password" 
                            class="w-full border border-[#BABABA] rounded-lg px-4 py-3 focus:outline-none focus:border-[#CD2828] focus:ring-1 focus:ring-[#CD2828]" 
                            placeholder="Kosongkan jika tidak ingin ubah">
                    @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                            class="w-full border border-[#BABABA] rounded-lg px-4 py-3 focus:outline-none focus:border-[#CD2828] focus:ring-1 focus:ring-[#CD2828]" 
                            placeholder="Ulangi password baru">
                    @error('password_confirmation') 
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                    @enderror
                </div>

                <div>
                    <label for="is_active" class="block text-sm font-medium text-gray-700 mb-2">Status Akun</label>
                    <select name="is_active" id="is_active" 
                            class="w-full border border-[#BABABA] rounded-lg px-4 py-3 focus:outline-none focus:border-[#CD2828] focus:ring-1 focus:ring-[#CD2828]">
                        <option value="1" {{ old('is_active', $user->is_active) ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active', !$user->is_active) ? 'selected' : '' }}>Non-Aktif (Suspended)</option>
                    </select>
                    @error('is_active') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>


            <div class="flex justify-end gap-4 mt-10">
                <a href="{{ route('admin.users.index') }}" class="px-8 py-3 bg-gray-200 text-gray-800 rounded-full font-medium hover:bg-gray-300 transition-colors">
                    Kembali
                </a>
                <button type="submit" class="px-8 py-3 bg-[#CD2828] text-white rounded-full font-medium hover:bg-[#832A2A] transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection