@extends('layouts.user')

@section('content')
<div class="container mx-auto px-4 ">
    <div class="flex flex-col lg:flex-row gap-8">
        {{-- CONTENT KANAN --}}
        <div class="w-full lg:w-3/4 space-y-8">
            {{-- Bagian Profil --}}
            <div class="bg-white border border-gray-100 rounded-[2.5rem] p-8 shadow-sm">
                <h3 class="text-sm font-black text-gray-800 uppercase italic tracking-widest mb-8">Informasi Akun</h3>
                
                <form action="{{ route('user.account.profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-4">Name</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="w-full bg-white border border-gray-200 rounded-2xl px-6 py-3 text-sm focus:outline-none focus:border-cyan-400">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-4">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="w-full bg-white border border-gray-200 rounded-2xl px-6 py-3 text-sm focus:outline-none focus:border-cyan-400">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-4">No Telp</label>
                        <input type="text" name="phone" value="{{ $user->phone ?? '0857xxxxxxxxx' }}" class="w-full bg-white border border-gray-200 rounded-2xl px-6 py-3 text-sm focus:outline-none focus:border-cyan-400">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-cyan-400 text-white px-10 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-black transition-all shadow-lg shadow-cyan-100">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Bagian Password --}}
            <div class="bg-white border border-gray-100 rounded-[2.5rem] p-8 shadow-sm">
                <h3 class="text-sm font-black text-gray-800 uppercase italic tracking-widest mb-8">Ubah Password</h3>
                
                <form action="{{ route('user.account.profile.update.password') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-4">Password</label>
                        <input type="password" name="password" class="w-full bg-white border border-gray-200 rounded-2xl px-6 py-3 text-sm focus:outline-none focus:border-cyan-400">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-4">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="w-full bg-white border border-gray-200 rounded-2xl px-6 py-3 text-sm focus:outline-none focus:border-cyan-400">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-cyan-400 text-white px-10 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-black transition-all shadow-lg shadow-cyan-100">
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection