@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    {{-- HEADER --}}
    <div class="mb-10 flex items-center gap-4 px-2">
        <a href="{{ route('admin.users.index') }}" class="bg-[#F9F9F9] p-3 rounded-2xl hover:bg-[#202020] hover:text-white transition-all text-[#BABABA]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-3xl font-black text-[#202020] uppercase tracking-tighter">
                {{ $user->role == 'staff' ? 'Staff' : 'Customer' }} Detail
            </h1>
            <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-widest mt-1">Identity Profile: {{ $user->name }}</p>
        </div>
    </div>

    <div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] p-10 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            {{-- Info Dasar --}}
            <div class="space-y-6">
                <div>
                    <p class="text-[9px] font-black text-[#BABABA] uppercase tracking-widest mb-1">Full Name</p>
                    <p class="text-xl font-black text-[#202020] uppercase tracking-tight">{{ $user->name }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-black text-[#BABABA] uppercase tracking-widest mb-1">Email / Username</p>
                    <p class="text-lg font-bold text-[#202020] lowercase tracking-tight">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-black text-[#BABABA] uppercase tracking-widest mb-1">Phone Number</p>
                    <p class="text-lg font-bold text-[#202020]">{{ $user->phone ?? 'NOT PROVIDED' }}</p>
                </div>
            </div>

            {{-- Info Status --}}
            <div class="space-y-6">
                <div>
                    <p class="text-[9px] font-black text-[#BABABA] uppercase tracking-widest mb-2">Account Status</p>
                    <span class="px-4 py-1.5 rounded-xl font-black text-[9px] uppercase tracking-widest {{ $user->is_active ? 'bg-green-50 text-green-500' : 'bg-red-50 text-[#CD2828]' }}">
                        {{ $user->is_active ? 'ACTIVE MEMBER' : 'SUSPENDED' }}
                    </span>
                </div>
                <div>
                    <p class="text-[9px] font-black text-[#BABABA] uppercase tracking-widest mb-1">Registration Date</p>
                    <p class="text-lg font-bold text-[#202020] uppercase tracking-tighter">{{ $user->created_at->format('d M Y • H:i') }}</p>
                </div>
            </div>
        </div>

        {{-- Section Pesanan (Hanya Muncul Jika Customer) --}}
        @if($user->role !== 'admin')
        <div class="mt-12 pt-10 border-t border-[#F9F9F9]">
            <h3 class="text-[10px] font-black text-[#BABABA] uppercase tracking-[0.3em] mb-8">Purchase Analytics</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-[#F9F9F9] p-8 rounded-3xl text-center">
                    <p class="text-[9px] font-black text-[#BABABA] uppercase tracking-widest mb-2">Total Orders</p>
                    <p class="text-4xl font-black text-[#202020] tracking-tighter">{{ $ordersCount ?? 0 }}</p>
                </div>
                <div class="bg-[#F9F9F9] p-8 rounded-3xl text-center border-l-4 border-l-[#CD2828]">
                    <p class="text-[9px] font-black text-[#BABABA] uppercase tracking-widest mb-2">Lifetime Spending</p>
                    <p class="text-3xl font-black text-[#CD2828] tracking-tighter">Rp{{ number_format($totalSpending ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        @endif

        {{-- Tombol Aksi --}}
        <div class="flex justify-end gap-3 mt-12 pt-8 border-t border-[#F9F9F9]">
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('PERMANENTLY DELETE THIS ACCOUNT?');">
                @csrf @method('DELETE')
                <button type="submit" class="bg-red-50 text-[#CD2828] px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#CD2828] hover:text-white transition-all">
                    Terminated Account
                </button>
            </form>
        </div>
    </div>
</div>
@endsection