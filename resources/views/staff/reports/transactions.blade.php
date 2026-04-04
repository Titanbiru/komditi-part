@extends('layouts.staff')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Transaction History</h1>
</div>

{{-- NAV --}}
<div class="bg-white border-2 border-black rounded-3xl p-6 mb-10 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
    <a href="{{ route('staff.reports.index') }}" class="bg-gray-200 p-2 rounded-full hover:bg-gray-300 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <div class="flex gap-2">
        @php
                $menus = [
                    ['name' => 'Sales', 'route' => 'staff.reports.sales'],
                    ['name' => 'Stock', 'route' => 'staff.reports.stocks'],
                    ['name' => 'Transaction', 'route' => 'staff.reports.transactions'],
                ];
            @endphp
        @foreach($menus as $menu)
            <a href="{{ route($menu['route']) }}" class="px-6 py-1 rounded-full border-2 border-black text-sm font-bold {{ Route::currentRouteName() == $menu['route'] ? 'bg-[#CD2828] text-white border-[#CD2828]' : 'bg-white' }}">
                {{ $menu['name'] }}
            </a>
        @endforeach
    </div>
    <form class="flex gap-2">
        <input type="date" name="start" value="{{ request('start') }}" class="border-2 border-black rounded-lg px-2 text-sm">
        <input type="date" name="end" value="{{ request('end') }}" class="border-2 border-black rounded-lg px-2 text-sm">
        <button type="submit" class="bg-[#1BCFD5] text-white px-4 py-1 rounded-full font-bold shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">Filter</button>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10 text-center">
    <div class="bg-white border-2 border-black p-4 rounded-xl"><h5 class="text-xs font-bold text-gray-400">TOTAL</h5><p class="text-2xl font-black">{{ $total }}</p></div>
    <div class="bg-white border-2 border-black p-4 rounded-xl"><h5 class="text-xs font-bold text-gray-400">PENDING</h5><p class="text-2xl font-black text-orange-500">{{ $pending }}</p></div>
    <div class="bg-white border-2 border-black p-4 rounded-xl"><h5 class="text-xs font-bold text-gray-400">PAID</h5><p class="text-2xl font-black text-green-500">{{ $paid }}</p></div>
    <div class="bg-black text-white p-4 rounded-xl"><h5 class="text-xs font-bold text-gray-400">VALUE</h5><p class="text-xl font-black">Rp {{ number_format($totalValue, 0, ',', '.') }}</p></div>
</div>

<div class="bg-white border-2 border-black rounded-2xl overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-100 border-b-2 border-black">
            <tr>
                <th class="p-4 font-black text-xs uppercase">Customer</th>
                <th class="p-4 font-black text-xs uppercase">Total</th>
                <th class="p-4 font-black text-xs uppercase">Status</th>
                <th class="p-4 font-black text-xs uppercase">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction as $t)
            <tr class="border-b border-gray-100">
                <td class="p-4 font-bold">{{ $t->user->name ?? 'Guest' }}</td>
                <td class="p-4">Rp {{ number_format($t->grand_total, 0, ',', '.') }}</td>
                <td class="p-4">
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase border-2 border-black {{ $t->payment_status == 'paid' ? 'bg-green-400' : 'bg-red-400' }}">
                        {{ $t->payment_status }}
                    </span>
                </td>
                <td class="p-4">
                    <a href="{{ route('staff.reports.transactionShow', $t->id) }}" class="text-blue-600 font-bold hover:underline">Detail →</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $transaction->links() }}</div>
@endsection