@extends('layouts.user')

@section('content')

<div class="bg-white border border-gray-100 rounded-[2.5rem] p-4 shadow-sm">
    <div class="flex justify-between items-center mb-8">
        <h3 class="text-sm font-black text-gray-800 uppercase italic tracking-widest text-left">Alamat Kamu</h3>
        <a href="{{ route('user.account.addresses.create') }}" class="bg-cyan-400 text-white px-6 py-2 rounded-2xl font-black text-[10px] uppercase tracking-widest flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="3"/></svg>
            Tambah Alamat
        </a>
    </div>

    @if($addresses->isEmpty())
        <div class="py-20 text-center space-y-4">
            <div class="bg-orange-50 text-orange-400 w-fit mx-auto p-4 rounded-full">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-width="2"/></svg>
            </div>
            <p class="text-gray-500 font-bold italic uppercase text-xs">Kamu belum ada alamat untuk mengirim</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($addresses as $address)
                <div class="border border-gray-100 p-6 rounded-3xl flex justify-between items-start gap-4 {{ $address->is_default ? 'bg-cyan-50/30 border-cyan-100' : '' }}">
                    <div class="flex gap-6">
                        <span class="text-[10px] font-black uppercase text-cyan-400 italic bg-cyan-50 px-3 py-1 rounded-full h-fit">
                            {{ $address->type }}
                        </span>
                        <div class="space-y-1">
                            <p class="text-sm font-black text-gray-800 uppercase tracking-tight">
                                {{ $address->recipient_name }} | {{ $address->phone }}
                                @if($address->is_default) <span class="ml-2 text-[9px] bg-cyan-400 text-white px-2 py-0.5 rounded-full">Utama</span> @endif
                            </p>
                            <p class="text-xs text-gray-500 leading-relaxed max-w-md">
                                {{ $address->address }}, {{ $address->city }}, {{ $address->province }}, {{ $address->postal_code }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        {{-- Tombol Edit --}}
                        <a href="{{ route('user.account.addresses.edit', $address->id) }}" 
                        class="text-cyan-400 font-bold text-[10px] uppercase hover:underline whitespace-nowrap">
                        Edit
                        </a>

                        {{-- Tombol Hapus --}}
                        <form action="{{ route('user.account.addresses.destroy', $address->id) }}" 
                            method="POST" 
                            onsubmit="return confirm('Hapus alamat ini?')"
                            class="inline-flex items-center"> {{-- Tambah inline-flex di sini --}}
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="text-red-400 font-bold text-[10px] uppercase hover:underline whitespace-nowrap">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection