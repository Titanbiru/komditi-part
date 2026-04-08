@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto pb-20">
    {{-- HEADER --}}
    <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 px-2">
        <div>
            <h1 class="text-3xl font-black text-[#202020] uppercase tracking-tighter">System Backup</h1>
            <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-widest mt-1">Database Preservation & Disaster Recovery</p>
        </div>
        <span class="bg-[#202020] text-white text-[9px] px-4 py-1.5 rounded-xl font-black uppercase tracking-widest shadow-sm">
            SQL Engine Only
        </span>
    </div>

    {{-- Notifikasi --}}
    @if(session('error') || session('success'))
        <div class="mb-8 p-5 rounded-[1.5rem] font-black text-[10px] uppercase tracking-widest border flex items-center gap-4 {{ session('error') ? 'bg-red-50 border-red-100 text-[#CD2828]' : 'bg-green-50 border-green-100 text-[#1BCFD5]' }}">
            <div class="w-8 h-8 rounded-full flex items-center justify-center {{ session('error') ? 'bg-[#CD2828] text-white' : 'bg-[#1BCFD5] text-white' }}">
                @if(session('error')) ! @else ✓ @endif
            </div>
            {{ session('error') ?? session('success') }}
        </div>
    @endif
    
    {{-- Hero Backup Card --}}
    <div class="bg-white border border-[#BABABA]/20 rounded-[3rem] p-12 flex flex-col items-center shadow-sm mb-12 relative overflow-hidden">
        {{-- Aksen Latar Belakang Halus --}}
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-[#1BCFD5]/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-[#CD2828]/5 rounded-full blur-3xl"></div>

        <div class="bg-[#F9F9F9] p-6 rounded-[2.5rem] mb-6 border border-[#BABABA]/10">
            <svg class="w-12 h-12 text-[#202020]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 7v10c0 2.21 3.58 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.58 4 8 4s8-1.79 8-4M4 7c0-2.21 3.58-4 8-4s8 1.79 8 4m0 5c0 2.21-3.58 4-8 4s-8-1.79-8-4"/>
            </svg>
        </div>
        
        <div class="text-center mb-10">
            @if($lastBackup)
                <h3 class="text-[10px] font-black text-[#BABABA] uppercase tracking-[0.4em] mb-2">Latest Vault Entry</h3>
                <p class="text-2xl font-black text-[#202020] tracking-tighter mb-1">{{ $lastBackup['name'] }}</p>
                <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-widest">
                    Captured: {{ $lastBackup['created_at'] }} • Size: {{ $lastBackup['size'] }}
                </p>
            @else
                <p class="text-sm font-black text-[#BABABA] uppercase tracking-widest italic">No snapshots available in vault.</p>
            @endif
        </div>

        <div class="flex flex-col sm:flex-row gap-4 w-full max-w-md">
            <form action="{{ route('admin.backup.generate') }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full bg-[#1BCFD5] text-white px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-[#202020] transition-all shadow-lg shadow-cyan-100">
                    Create New Snapshot
                </button>
            </form>
            @if($lastBackup)
                <a href="{{ route('admin.backups.download', $lastBackup['name']) }}" class="flex-1 bg-[#202020] text-white px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest text-center hover:bg-[#CD2828] transition-all shadow-lg">
                    Export SQL
                </a>
            @endif
        </div>
    </div>

    {{-- History Table --}}
    <h2 class="text-[10px] font-black mb-6 uppercase tracking-[0.3em] text-[#BABABA] px-4 italic">Backup Repository Log</h2>
    <div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] overflow-hidden shadow-sm mb-20">
        <table class="w-full">
            <thead class="bg-[#F3F3F3] border-b-2 border-white text-[9px] font-black uppercase tracking-widest text-[#202020]">
                <tr>
                    <th class="p-6 text-left border-r border-white">Snapshot Filename</th>
                    <th class="p-6 text-center border-r border-white">Timestamp</th>
                    <th class="p-6 text-center border-r border-white">Storage</th>
                    <th class="p-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#BABABA]/10 text-[11px] font-bold uppercase text-[#202020]">
                @forelse($files as $file)
                <tr class="hover:bg-[#F9F9F9] transition-colors">
                    <td class="p-6 font-black tracking-tight">{{ $file['name'] }}</td>
                    <td class="p-6 text-center text-[#BABABA]">{{ $file['created_at'] }}</td>
                    <td class="p-6 text-center">
                        <span class="bg-[#F3F3F3] px-3 py-1 rounded-lg text-[9px] font-black">{{ $file['size'] }}</span>
                    </td>
                    <td class="p-6 text-center">
                        <div class="flex justify-center gap-6 text-[9px] font-black tracking-widest">
                            <a href="{{ route('admin.backups.download', $file['name']) }}" class="text-[#1BCFD5] hover:underline">EXPORT</a>
                            <form action="{{ route('admin.backups.delete', $file['name']) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-[#CD2828] hover:underline" onclick="return confirm('PERMANENTLY DELETE SNAPSHOT?')">PURGE</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-16 text-center text-[#BABABA] text-[10px] font-black uppercase tracking-widest">Vault is currently empty</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Emergency Restore Section (Ultra Compact) --}}
    <div class="max-w-2xl mx-auto pt-10 border-t border-[#BABABA]/10">
        <div class="bg-white border border-[#CD2828]/20 rounded-[2rem] overflow-hidden shadow-sm">
            {{-- Label Bahaya Tipis --}}
            <div class="bg-[#CD2828] h-1 w-full"></div>
            
            <div class="p-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center text-[#CD2828]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-[11px] font-black text-[#202020] uppercase tracking-widest">Emergency Restore</h2>
                        <p class="text-[9px] font-bold text-[#BABABA] uppercase tracking-widest leading-tight">Overwrite database with SQL file</p>
                    </div>
                </div>

                <form action="{{ route('admin.backup.restore') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    {{-- Input File Minimalis --}}
                    <div class="group">
                        <label class="block text-[8px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Select SQL Snapshot</label>
                        <input type="file" name="backup_file" required 
                            class="w-full bg-[#F9F9F9] border border-[#BABABA]/10 rounded-xl p-3 text-[10px] font-black text-[#202020] file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[9px] file:font-black file:bg-[#202020] file:bg-hover[#CD2828] file:text-white focus:outline-none transition-all">
                    </div>
                    
                    {{-- Checkbox Konfirmasi --}}
                    <label class="flex items-center gap-3 cursor-pointer group p-1">
                        <input type="checkbox" name="confirm" required id="confirm_restore" class="w-4 h-4 accent-[#CD2828] rounded border-[#BABABA]/20">
                        <span class="text-[8px] font-black text-[#BABABA] uppercase tracking-widest group-hover:text-[#CD2828] transition-colors">
                            I understand this action is irreversible.
                        </span>
                    </label>

                    {{-- Tombol Padat --}}
                    <button type="submit" class="w-full bg-[#202020] text-white py-3.5 rounded-xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-[#CD2828] transition-all shadow-sm active:scale-95">
                        Execute Restore
                    </button>
                </form>
            </div>
        </div>
        
        <p class="text-center mt-6 text-[8px] font-black text-[#BABABA] uppercase tracking-[0.4em] hover:text-[#202020] transition-all border-b border-[#BABABA]/20 inline-block mx-auto flex w-fit pb-1">
            Careful: Current records will be purged
        </p>
    </div>
</div>
@endsection