@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-[#CD2828]">Staff & User Management</h1>
        <div class="flex items-center gap-3">
            <span class="text-gray-700 font-medium">{{ auth()->user()->name ?? 'Admin' }}</span>
            <span class="px-4 py-1 bg-[#832A2A] text-white text-sm rounded-full font-medium">
                Admin
            </span>
        </div>
    </div>
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg border border-green-200">
            {{ session('success') }}
        </div>
    @endif
    

    <!-- Manage Staff -->
    <div class="bg-white rounded-xl shadow-md border border-[#BABABA] overflow-hidden mb-12">
        <div class="flex justify-between items-center px-6 py-5 border-b border-[#BABABA] bg-gray-50">
            <h2 class="text-xl font-bold text-[#CD2828]">Manage Staff</h2>
            <div class="flex items-center gap-4">
                <input type="text" placeholder="search" class="border border-[#BABABA] rounded-full px-4 py-2 text-sm focus:outline-none focus:border-[#CD2828] w-64">
                <a href="{{ route('admin.users.create') }}" class="bg-[#CD2828] text-white px-5 py-2 rounded-full font-medium hover:bg-[#832A2A] transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Add New Staff
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[#BABABA]">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Name</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Username</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Phone</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Account Created</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#BABABA]">
                @forelse($staff as $s)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $s->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $s->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $s->phone ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($s->is_active)
                                <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                    <span class="w-2 h-2 mr-1 bg-green-500 rounded-full"></span> Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                                    <span class="w-2 h-2 mr-1 bg-red-500 rounded-full"></span> Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $s->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-sm flex items-center gap-4">
                            <a href="{{ route('admin.users.show', $s->id) }}" class="text-[#CD2828] hover:underline font-medium">View</a>
                            <a href="{{ route('admin.users.edit', $s) }}" class="text-blue-600 hover:underline font-medium">Edit</a>
                            <form action="{{ route('admin.users.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Yakin hapus staff {{ $s->name }}?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition-colors">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">Belum ada staff terdaftar</td>
                    </tr>
                @endforelse
            </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-[#BABABA] bg-gray-50">
            {{ $staff->appends(['staff_page' => $staff->currentPage()])->links() }}
        </div>
    </div>

    <!-- User Account (mirip, accent biru) -->
    <div class="bg-white rounded-xl shadow-md border border-[#BABABA] overflow-hidden">
        <div class="flex justify-between items-center px-6 py-5 border-b border-[#BABABA] bg-gray-50">
            <h2 class="text-xl font-bold text-[#1BCFD5]">User Account</h2>
            <input type="text" placeholder="search" class="border border-[#BABABA] rounded-full px-4 py-2 text-sm focus:outline-none focus:border-[#1BCFD5] w-64">
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[#BABABA]">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Name</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Username</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Phone</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Account Created</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#BABABA]">
                    @forelse($users as $u)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $u->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $u->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $u->phone ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">Active</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $u->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('admin.users.show', $u) }}" class="text-[#1BCFD5] hover:underline font-medium">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">Belum ada user terdaftar</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-[#BABABA] bg-gray-50">
            {{ $users->appends(['user_page' => $users->currentPage()])->links() }}
        </div>
    </div>
@endsection
