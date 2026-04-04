@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-[#CD2828]">Detail {{ ucfirst($user->role) }}: {{ $user->name }}</h1>
        <a href="{{ route('admin.users.index') }}" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-full font-medium hover:bg-gray-300 transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-[#BABABA] p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <p class="text-sm text-gray-600">Name</p>
                <p class="text-xl font-medium">{{ $user->name }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600">Email/Username</p>
                <p class="text-xl font-medium">{{ $user->email }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600">Phone</p>
                <p class="text-xl font-medium">{{ $user->phone ?? '-' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600">Role</p>
                <p class="text-xl font-medium capitalize">{{ $user->role }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600">Account Created</p>
                <p class="text-xl font-medium">{{ $user->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600">Status</p>
                <span class="inline-block px-4 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">Active</span>
            </div>
        </div>

        <!-- Info tambahan (pesanan & total spending) -->
        <div class="mt-10 border-t border-[#BABABA] pt-8">
            <h3 class="text-xl font-bold text-[#CD2828] mb-4">Informasi Pesanan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <p class="text-sm text-gray-600">Jumlah Pesanan</p>
                    <p class="text-2xl font-bold">{{ $ordersCount }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Pengeluaran</p>
                    <p class="text-2xl font-bold text-[#CD2828]">Rp {{ number_format($totalSpending ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end gap-4 mt-10">
            <a href="{{ route('admin.users.edit', $user) }}" class="px-8 py-3 bg-gray-200 text-gray-800 rounded-full font-medium hover:bg-gray-300 transition-colors">
                Edit
            </a>
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus staff ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-8 py-3 bg-red-600 text-white rounded-full font-medium hover:bg-red-700 transition-colors">
                    Hapus
                </button>
            </form>
        </div>
    </div>
@endsection