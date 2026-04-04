@extends('layouts.staff')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Transaction</h1>
    <div class="relative">
        <form action="{{ route('staff.transactions.index') }}" method="GET">
            <input type="text" name="search" placeholder="search" value="{{ request('search') }}"
                class="border border-[#BABABA] rounded-full px-4 py-2 text-sm focus:outline-none focus:border-[#CD2828] w-80 shadow-sm">
        </form>
        <p class="text-[10px] text-gray-400 mt-1 text-center font-medium italic">*find by category using search</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="border-2 border-black rounded-2xl p-6 bg-white">
        <h3 class="text-sm font-bold mb-2 uppercase tracking-tight">Total Transaction</h3>
        <p class="text-4xl font-bold text-[#CD2828]">{{ $totalTransaction }}</p>
    </div>
    <div class="border-2 border-black rounded-2xl p-6 bg-white">
        <h3 class="text-sm font-bold mb-2 uppercase tracking-tight">Pending Transaction</h3>
        <p class="text-3xl font-bold text-[#CD2828]">{{ $pendingTransaction }} <span class="text-black text-2xl font-bold">transaction</span></p>
    </div>
    <div class="border-2 border-black rounded-2xl p-6 bg-white">
        <h3 class="text-sm font-bold mb-2 uppercase tracking-tight">Paid Transaction</h3>
        <p class="text-3xl font-bold text-[#CD2828]">{{ $paidTransaction }} <span class="text-black text-2xl font-bold">transaction</span></p>
    </div>
    <div class="border-2 border-black rounded-2xl p-6 bg-white">
        <h3 class="text-sm font-bold mb-2 uppercase tracking-tight">Shippment</h3>
        <p class="text-3xl font-bold text-[#CD2828]">{{ $shipment }} <span class="text-black text-2xl font-bold">transaction</span></p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-md border border-[#BABABA] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-[#C4C4C4]">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-bold text-black border-r border-white">Order id</th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-black border-r border-white text-center">Date</th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-black border-r border-white">Customer Name</th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-black border-r border-white">Subtotal</th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-black border-r border-white text-center">Status Payment</th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-black border-r border-white text-center">Status Shippment</th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-black text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#BABABA]">
                @forelse($transactions as $t)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $t->order_number }}</td>
                    <td class="px-6 py-4 text-sm text-center text-gray-600">{{ $t->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800 font-medium">{{ $t->user->name }}</td>
                    <td class="px-6 py-4 text-sm font-bold">Rp {{ number_format($t->grand_total, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm text-center">
                        @if($t->payment_status == 'paid')
                            <span class="text-green-500 font-bold">Paid</span>
                        @elseif($t->payment_status == 'pending')
                            <span class="text-yellow-500 font-bold">Unpaid</span>
                        @else
                            <span class="text-red-500 font-bold uppercase">{{ $t->payment_status }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-center font-medium text-gray-700">
                        {{ ucfirst($t->shipment_status) }}
                    </td>
                    <td class="px-6 py-4 text-sm text-center">
                        <a href="{{ route('staff.transactions.show', $t->id) }}" class="text-[#1BCFD5] font-bold hover:underline">Update</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="p-10 text-center italic text-gray-400">No transactions found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-[#BABABA] bg-gray-50">
        {{ $transactions->appends(request()->query())->links() }}
    </div>
</div>
@endsection