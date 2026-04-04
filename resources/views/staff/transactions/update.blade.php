@extends('layouts.staff')

@section('content')
<div class="max-w-6xl mx-auto pb-20">
    <div class="flex justify-between items-start mb-8">
        <div>
            <h1 class="text-3xl font-bold text-black">Detail Transaction</h1>
            <div class="flex gap-3 mt-4">
                <span class="px-6 py-1 bg-green-500 text-white rounded-full font-bold text-sm uppercase">{{ $transaction->payment_status }}</span>
                <span class="px-6 py-1 bg-[#1BCFD5] text-white rounded-full font-bold text-sm uppercase">{{ $transaction->shipment_status }}</span>
            </div>
        </div>
        <div class="text-right">
            <p class="text-xl font-bold">Order id: <span class="text-gray-600 font-medium">{{ $transaction->order_number }}</span></p>
            <p class="text-gray-500 font-bold mt-2">{{ $transaction->created_at->format('d/m/Y') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10 text-lg font-medium">
        <div class="space-y-2">
            <p><span class="font-bold uppercase">Customer name:</span> {{ $transaction->user->name }}</p>
            <p><span class="font-bold">No telp:</span> {{ $transaction->user->phone ?? '-' }}</p>
            <p><span class="font-bold">Email:</span> {{ $transaction->user->email }}</p>
        </div>
        <div>
            <p><span class="font-bold">Address:</span></p>
            <p class="text-gray-600 leading-relaxed">{{ $transaction->shipping_snapshot['address'] ?? 'No Address Data' }}</p>
        </div>
    </div>

    <div class="bg-white border-2 border-black rounded-xl overflow-hidden mb-10">
        <table class="min-w-full">
            <thead class="bg-[#C4C4C4]">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-bold text-black border-r border-white">Product Name</th>
                    <th class="px-6 py-3 text-center text-sm font-bold text-black border-r border-white">Price</th>
                    <th class="px-6 py-3 text-center text-sm font-bold text-black border-r border-white">Qty</th>
                    <th class="px-6 py-3 text-center text-sm font-bold text-black">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($transaction->items as $item)
                <tr>
                    <td class="px-6 py-4 text-sm font-medium">{{ $item->product_name_snapshot }}</td>
                    <td class="px-6 py-4 text-sm text-center">Rp {{ number_format($item->product_price_snapshot, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm text-center font-bold">{{ $item->quantity }}</td>
                    <td class="px-6 py-4 text-sm text-center font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr class="bg-gray-50 border-t-2 border-black">
                    <td colspan="3" class="px-6 py-3 text-right font-bold">Subtotal</td>
                    <td class="px-6 py-3 text-center font-black">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <div class="space-y-4">
            <h3 class="font-bold text-xl mb-4">Payment Summary</h3>
            <div class="bg-white border-2 border-gray-200 rounded-xl overflow-hidden">
                <table class="min-w-full text-sm">
                    <tr class="border-b bg-gray-50"><td class="p-4 font-bold">Subtotal</td><td class="p-4 text-right">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td></tr>
                    <tr class="border-b"><td class="p-4 font-bold">Shippment Cost</td><td class="p-4 text-right">Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</td></tr>
                    <tr class="border-b"><td class="p-4 font-bold">Discount</td><td class="p-4 text-right">10%</td></tr>
                    <tr class="border-b font-black text-lg bg-gray-100"><td class="p-4">Total Payment</td><td class="p-4 text-right">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</td></tr>
                    <tr class="border-b"><td class="p-4 font-bold">Payment Method</td><td class="p-4 text-right">Qris</td></tr>
                    <tr><td class="p-4 font-bold">Payment status</td><td class="p-4 text-right text-green-600 font-black uppercase">{{ $transaction->payment_status }}</td></tr>
                </table>
            </div>
            
            <h3 class="font-bold text-xl mt-8 mb-4">Proof Payment</h3>
            <div class="w-48 border-2 border-dashed border-gray-300 rounded-xl p-2 bg-gray-50">
                <img src="https://via.placeholder.com/200x400" alt="Proof" class="rounded-lg shadow-sm">
                <div class="flex flex-col gap-2 mt-4">
                    <button class="bg-[#1BCFD5] text-white py-2 rounded-lg font-bold text-xs uppercase">Confirm Payment</button>
                    <button class="bg-red-500 text-white py-2 rounded-lg font-bold text-xs uppercase">Reject Payment</button>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <h3 class="font-bold text-xl mb-4">Shipping Information</h3>
            <div class="bg-white border-2 border-gray-200 rounded-xl p-6 space-y-4">
                <div class="flex justify-between"><span>Courrier</span><span class="font-bold">J&T</span></div>
                <div class="flex justify-between"><span>Status</span><span class="font-bold text-[#1BCFD5] uppercase">{{ $transaction->shipment_status }}</span></div>
                <div class="flex justify-between"><span>No Resi</span><span class="font-bold text-gray-500 italic">{{ $transaction->resi_number ?? 'Not assigned yet' }}</span></div>
            </div>

            <div class="mt-10">
                <h3 class="font-bold text-xl mb-4">Update Shipping Status</h3>
                <form action="{{ route('staff.transactions.updateStatus', $transaction->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="text-sm font-bold text-gray-600">Shipping Status</label>
                        <select name="shipping_status" class="w-full border-2 border-gray-300 rounded-xl p-3 mt-1 focus:border-[#1BCFD5] outline-none font-bold">
                            <option value="pending" {{ $transaction->shipment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $transaction->shipment_status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $transaction->shipment_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $transaction->shipment_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="canceled" {{ $transaction->shipment_status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-bold text-gray-600">No Resi</label>
                        <input type="text" name="resi_number" value="{{ $transaction->resi_number }}" placeholder="Input resi number" 
                            class="w-full border-2 border-gray-300 rounded-xl p-3 mt-1 focus:border-[#1BCFD5] outline-none">
                    </div>
                    <div>
                        <label class="text-sm font-bold text-gray-600">Note</label>
                        <textarea name="note" placeholder="payment note" rows="3" 
                            class="w-full border-2 border-gray-300 rounded-xl p-3 mt-1 focus:border-[#1BCFD5] outline-none">{{ $transaction->note }}</textarea>
                    </div>
                    <button type="submit" class="w-full bg-[#1BCFD5] text-white py-3 rounded-xl font-bold text-lg hover:bg-[#16adb3] transition-colors shadow-lg">
                        Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="mt-12">
        <a href="{{ route('staff.transactions.index') }}" class="px-8 py-2 bg-[#BABABA] text-black font-bold rounded-full flex items-center gap-2 w-max">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Kembali
        </a>
    </div>
</div>
@endsection