@extends('layouts.admin')

@section('content')
<div class="mb-10 flex items-center gap-4 px-2">
    <a href="{{ route('admin.users.index') }}" class="bg-[#F9F9F9] p-3 rounded-2xl hover:bg-[#202020] hover:text-white transition-all text-[#BABABA]">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <div>
        <h1 class="text-3xl font-black text-[#CD2828] uppercase tracking-tighter">
            {{ isset($user) ? 'Edit Member' : 'New Staff' }}
        </h1>
        <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-widest mt-1">Assign roles and credentials</p>
    </div>
</div>

<div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] p-8 md:p-12 shadow-sm max-w-4xl">
    <form method="POST" action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" class="space-y-8">
        @csrf
        @if(isset($user)) @method('PUT') @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required 
                    class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-4 text-[11px] font-black uppercase text-[#202020] outline-none focus:ring-1 focus:ring-[#CD2828]">
            </div>
            <div>
                <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required 
                    class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-4 text-[11px] font-black text-[#202020] outline-none focus:ring-1 focus:ring-[#CD2828]">
            </div>
            <div>
                <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" 
                    class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-4 text-[11px] font-black text-[#202020] outline-none">
            </div>
            <div>
                <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Account Status</label>
                <select name="is_active" class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-4 text-[11px] font-black text-[#202020] outline-none">
                    <option value="1" {{ old('is_active', $user->is_active ?? 1) == 1 ? 'selected' : '' }}>ACTIVE STAFF</option>
                    <option value="0" {{ old('is_active', $user->is_active ?? 1) == 0 ? 'selected' : '' }}>SUSPENDED</option>
                </select>
            </div>
            <div>
                <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Password</label>
                <input type="password" name="password" placeholder="{{ isset($user) ? 'LEAVE BLANK IF NO CHANGE' : 'MIN 8 CHARACTERS' }}"
                    {{ isset($user) ? '' : 'required' }}
                    class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-4 text-[11px] font-black text-[#202020] outline-none">
            </div>
            <div>
                <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Confirm Password</label>
                <input type="password" name="password_confirmation" 
                    class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-4 text-[11px] font-black text-[#202020] outline-none">
            </div>
        </div>

        <div class="flex justify-end pt-6">
            <button type="submit" class="bg-[#202020] text-white px-12 py-4 rounded-2xl text-[11px] font-black uppercase tracking-[0.2em] hover:bg-[#CD2828] transition-all shadow-lg">
                {{ isset($user) ? 'Save Changes' : 'Create Account' }}
            </button>
        </div>
    </form>
</div>
@endsection