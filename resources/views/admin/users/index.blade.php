@extends('layouts.admin')

@section('content')
<div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 px-2">
    <div>
        <h1 class="text-3xl font-black text-[#CD2828] uppercase tracking-tighter">Account Management</h1>
        <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-widest mt-1">Manage Staff, Users, and Security Settings</p>
    </div>
    <div class="flex items-center gap-3 bg-white p-2 rounded-2xl border border-[#BABABA]/20 shadow-sm">
        <div class="text-right">
            <p class="text-[10px] font-black text-[#202020] uppercase leading-none">{{ auth()->user()->name ?? 'Admin' }}</p>
            <p class="text-[8px] font-bold text-[#BABABA] uppercase tracking-widest">Master Admin</p>
        </div>
        <div class="w-8 h-8 bg-[#CD2828] rounded-xl flex items-center justify-center text-white font-black text-xs">A</div>
    </div>
</div>

@if (session('success'))
    <div class="mb-6 p-4 bg-green-50 text-green-600 rounded-2xl border border-green-100 text-[10px] font-black uppercase tracking-widest">
        {{ session('success') }}
    </div>
@endif

{{-- SECTION 1: MANAGE STAFF (ACCENT RED) --}}
<div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] overflow-hidden shadow-sm mb-12">
    <div class="flex flex-col md:flex-row justify-between items-center px-8 py-6 bg-[#F3F3F3] border-b-2 border-white gap-4">
        <h2 class="text-xs font-black text-[#CD2828] uppercase tracking-[0.2em]">Staff Members</h2>
        <div class="flex items-center gap-4 w-full md:w-auto">
            <input type="text" placeholder="SEARCH STAFF..." class="bg-white border border-[#BABABA]/10 rounded-xl px-4 py-2 text-[10px] font-black uppercase focus:outline-none focus:border-[#CD2828] w-full md:w-64">
            <a href="{{ route('admin.users.create') }}" class="bg-[#CD2828] text-white px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#202020] transition-all flex items-center gap-2 flex-shrink-0">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                Add Staff
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#F9F9F9] border-b border-[#BABABA]/10 text-[9px] font-black uppercase text-[#BABABA] tracking-widest">
                <tr>
                    <th class="px-8 py-5 text-left border-r border-[#BABABA]/5">Name</th>
                    <th class="px-8 py-5 text-left border-r border-[#BABABA]/5">Email/User</th>
                    <th class="px-8 py-5 text-center border-r border-[#BABABA]/5">Status</th>
                    <th class="px-8 py-5 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#BABABA]/10 text-[11px] font-bold uppercase text-[#202020]">
                @forelse($staff as $s)
                <tr class="hover:bg-[#F9F9F9] transition-colors">
                    <td class="px-8 py-5 font-black">{{ $s->name }}</td>
                    <td class="px-8 py-5 text-[#BABABA] tracking-tighter">{{ $s->email }}</td>
                    <td class="px-8 py-5 text-center">
                        <span class="px-3 py-1 rounded-lg text-[8px] font-black {{ $s->is_active ? 'bg-green-50 text-green-500' : 'bg-red-50 text-red-500' }}">
                            {{ $s->is_active ? 'ACTIVE' : 'SUSPENDED' }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-center">
                        <div class="flex items-center justify-center gap-4 text-[9px] font-black tracking-widest">
                            <a href="{{ route('admin.users.edit', $s) }}" class="text-[#1BCFD5] hover:underline">EDIT</a>
                            <form action="{{ route('admin.users.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus staff ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-[#CD2828] hover:underline">DELETE</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-8 py-10 text-center text-[#BABABA] text-[10px] font-black">NO STAFF FOUND</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-8 py-4 bg-[#F9F9F9]/50 border-t border-[#BABABA]/10 text-right">
        {{ $staff->appends(['staff_page' => $staff->currentPage()])->links() }}
    </div>
</div>

{{-- SECTION 2: USER ACCOUNT (ACCENT CYAN) --}}
<div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] overflow-hidden shadow-sm mb-12">
    <div class="flex flex-col md:flex-row justify-between items-center px-8 py-6 bg-[#F3F3F3] border-b-2 border-white gap-4">
        <h2 class="text-xs font-black text-[#1BCFD5] uppercase tracking-[0.2em]">Customer Accounts</h2>
        <input type="text" placeholder="SEARCH CUSTOMER..." class="bg-white border border-[#BABABA]/10 rounded-xl px-4 py-2 text-[10px] font-black uppercase focus:outline-none focus:border-[#1BCFD5] w-full md:w-64">
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#F9F9F9] border-b border-[#BABABA]/10 text-[9px] font-black uppercase text-[#BABABA] tracking-widest">
                <tr>
                    <th class="px-8 py-5 text-left border-r border-[#BABABA]/5">Name</th>
                    <th class="px-8 py-5 text-left border-r border-[#BABABA]/5">Email</th>
                    <th class="px-8 py-5 text-center border-r border-[#BABABA]/5">Phone</th>
                    <th class="px-8 py-5 text-center">Action</th>
                </tr>
            </thead>
            {{-- Section Customer Accounts --}}
            <tbody class="divide-y divide-[#BABABA]/10 text-[11px] font-bold uppercase text-[#202020]">
                @forelse($users as $u)
                <tr class="hover:bg-[#F9F9F9] transition-colors">
                    <td class="px-8 py-5 font-black">{{ $u->name }}</td>
                    <td class="px-8 py-5 text-[#BABABA] tracking-tighter lowercase">{{ $u->email }}</td>
                    <td class="px-8 py-5 text-center text-[#202020]">{{ $u->phone ?? '-' }}</td>
                    <td class="px-8 py-5 text-center">
                        <div class="flex items-center justify-center gap-4 text-[9px] font-black tracking-widest">
                            {{-- Action Baru --}}
                            <a href="{{ route('admin.users.show', $u) }}" class="text-[#1BCFD5] hover:underline">VIEW</a>
                            
                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('DELETE CUSTOMER: {{ $u->name }}?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-[#CD2828] hover:underline">DELETE</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-8 py-10 text-center text-[#BABABA] text-[10px] font-black uppercase">NO CUSTOMERS REGISTERED</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-8 py-4 bg-[#F9F9F9]/50 border-t border-[#BABABA]/10 text-right">
        {{ $users->appends(['user_page' => $users->currentPage()])->links() }}
    </div>
</div>

{{-- SECTION 3: SECURITY SETTINGS --}}
<div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] overflow-hidden shadow-sm max-w-2xl">
    <div class="px-8 py-6 bg-[#F3F3F3] border-b-2 border-white">
        <h2 class="text-xs font-black text-[#202020] uppercase tracking-[0.2em]">Security Settings</h2>
        <p class="text-[9px] text-[#BABABA] font-bold uppercase mt-1">Master Account Credentials</p>
    </div>
    <div class="p-8">
        <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-6">
            @csrf @method('PUT')
            <div>
                <label class="block text-[#BABABA] text-[9px] font-black uppercase mb-2 ml-1">Admin Email</label>
                <input type="email" name="email" value="{{ auth()->user()->email }}" required 
                    class="w-full bg-[#F9F9F9] border-none rounded-xl px-4 py-3 text-[11px] font-black text-[#202020] outline-none focus:ring-1 focus:ring-[#CD2828]">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[#BABABA] text-[9px] font-black uppercase mb-2 ml-1">New Password</label>
                    <input type="password" name="new_password" placeholder="MIN 8 CHARS"
                        class="w-full bg-[#F9F9F9] border-none rounded-xl px-4 py-3 text-[11px] font-black text-[#202020] outline-none focus:ring-1 focus:ring-[#CD2828]">
                </div>
                <div>
                    <label class="block text-[#BABABA] text-[9px] font-black uppercase mb-2 ml-1">Confirm Password</label>
                    <input type="password" name="new_password_confirmation" 
                        class="w-full bg-[#F9F9F9] border-none rounded-xl px-4 py-3 text-[11px] font-black text-[#202020] outline-none focus:ring-1 focus:ring-[#CD2828]">
                </div>
            </div>
            <button type="submit" class="bg-[#202020] text-white px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#CD2828] transition-all shadow-lg active:scale-95">
                Update Security
            </button>
        </form>
    </div>
</div>
@endsection