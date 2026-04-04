@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto pb-20">
    <h1 class="text-3xl font-bold mb-8">Backup</h1>
@if(session('error'))
    <div class="bg-red-500 text-white p-4 rounded-xl mb-6 font-bold shadow-lg">
        Gagal: {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="bg-green-500 text-white p-4 rounded-xl mb-6 font-bold shadow-lg">
        Berhasil: {{ session('success') }}
    </div>
@endif
    
    <div class="bg-[#3D4B64] rounded-3xl p-10 flex flex-col items-center text-white mb-12 shadow-lg">
        <div class="mb-4">
            <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
        </div>
        
        <div class="text-center mb-6">
            @if($lastBackup)
                <p class="text-sm opacity-80">Last backup: {{ $lastBackup['created_at'] }}</p>
                <p class="text-sm opacity-80">File Size: {{ $lastBackup['size'] }}</p>
                <p class="text-xs italic opacity-60">Data Include: Product, User, Orders, Payment</p>
            @else
                <p class="text-sm opacity-80">No backup found.</p>
            @endif
        </div>

        <div class="flex gap-4">
            <form action="{{ route('admin.backup.generate') }}" method="POST">
                @csrf
                <button type="submit" class="bg-[#1BCFD5] text-white px-8 py-2 rounded-lg font-bold text-sm hover:opacity-90">Backup Now</button>
            </form>
            @if($lastBackup)
                <a href="{{ route('admin.backups.download', $lastBackup['name']) }}" class="bg-white text-black px-6 py-2 rounded-lg font-bold text-sm hover:bg-gray-100 transition-colors">Download Last Backup</a>
            @endif
        </div>
    </div>

    <h2 class="text-2xl font-bold mb-6 italic">Backup History</h2>
    <div class="bg-white border-2 border-[#BABABA] rounded-xl overflow-hidden shadow-sm mb-16">
        <table class="min-w-full">
            <thead class="bg-[#C4C4C4] border-b-2 border-black text-xs font-bold uppercase">
                <tr>
                    <th class="p-4 text-left border-r border-white">File Name</th>
                    <th class="p-4 text-center border-r border-white">Created At</th>
                    <th class="p-4 text-center border-r border-white">Sized</th>
                    <th class="p-4 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse($files as $file)
                <tr>
                    <td class="p-4 font-medium text-gray-800">{{ $file['name'] }}</td>
                    <td class="p-4 text-center text-gray-600">{{ $file['created_at'] }}</td>
                    <td class="p-4 text-center font-bold">{{ $file['size'] }}</td>
                    <td class="p-4 text-center">
                        <a href="{{ route('admin.backups.download', $file['name']) }}" class="text-[#1BCFD5] font-bold hover:underline">Download</a>
                        <span class="mx-1">/</span>
                        <form action="{{ route('admin.backups.delete', $file['name']) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 font-bold hover:underline" onclick="return confirm('Hapus backup ini?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-10 text-center text-gray-400 italic">No backup files available.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <hr class="border-t-4 border-[#CD2828] mb-12">

    <h2 class="text-2xl font-bold mb-6 italic">Restore</h2>
    <div class="bg-[#CD2828] rounded-xl border-2 border-[#CD2828] overflow-hidden shadow-lg">
        <div class="bg-[#CD2828] text-white p-2 text-center font-bold text-sm">
            Restore Data <br>
            <span class="text-[10px] font-normal uppercase italic tracking-wider text-yellow-200">This action will permanently delete current data</span>
        </div>
        <div class="bg-[#1A1A1A] p-8">
            <form action="{{ route('admin.backup.restore') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col md:flex-row items-center justify-center gap-6 mb-6">
                    <label class="text-white font-bold">Upload SQL Backup:</label>
                    <input type="file" name="backup_file" required class="bg-white rounded px-4 py-1 text-sm outline-none">
                </div>
                
                <div class="flex items-center justify-center gap-2 mb-8">
                    <input type="checkbox" name="confirm" required id="confirm_restore" class="w-5 h-5">
                    <label for="confirm_restore" class="text-white text-xs italic">I understand this action cannot be undone</label>
                </div>

                <div class="text-center">
                    <button type="submit" class="border-2 border-gray-500 bg-[#4A4A4A] text-white px-10 py-1 font-bold text-sm hover:bg-gray-700 transition-all shadow-md">
                        Restore Database
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection