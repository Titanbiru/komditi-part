@extends('layouts.staff')

@section('content')
<div class="max-w-6xl mx-auto pb-20">
    @php 
        // 1. KUNCI TOTAL: Jika status sudah DELIVERED atau CANCELED
        $isLocked = in_array($transaction->shipment_status, ['delivered', 'cancelled']); 
        
        // 2. KUNCI PAYMENT: Jika sudah PAID
        $isPaid = $transaction->payment_status == 'paid';

        $isCancelled = ($transaction->shipment_status === 'cancelled');
    @endphp

    {{-- HEADER MINIMALIS --}}
    <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 px-2">
        <div>
            <h1 class="text-3xl font-black text-[#202020] uppercase tracking-tighter">Order Management</h1>
            <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-widest mt-1">Order #{{ $transaction->order_number }} • {{ $transaction->created_at->format('d M Y, H:i') }}</p>
        </div>
        <div class="flex gap-2">
            <span class="px-4 py-1.5 {{ $isPaid ? 'bg-[#1BCFD5]' : 'bg-[#CD2828]' }} text-white rounded-xl font-black text-[9px] uppercase tracking-widest shadow-sm">
                {{ $transaction->payment_status }}
            </span>
            <span class="px-4 py-1.5 bg-[#BABABA] text-[#202020] rounded-xl font-black text-[9px] uppercase tracking-widest shadow-sm">
                {{ strtoupper($transaction->shipment_status) }}
            </span>
        </div>
    </div>

    {{-- CUSTOMER & ADDRESS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
        <div class="bg-white p-8 rounded-[2rem] border border-[#BABABA]/20 shadow-sm flex flex-col justify-center">
            <p class="text-[9px] font-black text-[#BABABA] uppercase tracking-[0.3em] mb-4">Customer Information</p>
            <div class="space-y-1">
                <p class="text-sm font-black text-[#202020] uppercase">{{ $transaction->user->name }}</p>
                <p class="text-xs font-bold text-gray-500">{{ $transaction->shipping_phone }}</p>
                <p class="text-xs font-bold text-gray-400">{{ $transaction->user->email }}</p>
            </div>
        </div>
        <div class="bg-white p-8 rounded-[2rem] border border-[#BABABA]/20 shadow-sm flex flex-col justify-center">
            <p class="text-[9px] font-black text-[#BABABA] uppercase tracking-[0.3em] mb-4">Shipping Destination</p>
            <p class="text-xs font-bold text-[#202020] leading-relaxed uppercase">{{ $transaction->shipping_address }}</p>
        </div>
    </div>

    {{-- ORDER ITEMS TABLE --}}
    <div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] overflow-hidden mb-10 shadow-sm">
        <table class="min-w-full">
            <thead class="bg-[#F9F9F9] border-b border-[#BABABA]/10 text-[9px] font-black text-[#BABABA] uppercase tracking-widest">
                <tr>
                    <th class="px-8 py-5 text-left">Item Description</th>
                    <th class="px-6 py-5 text-center">Price</th>
                    <th class="px-6 py-5 text-center">Qty</th>
                    <th class="px-8 py-5 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#BABABA]/5 text-[11px] font-bold uppercase text-[#202020]">
                @foreach($transaction->items as $item)
                <tr>
                    <td class="px-8 py-5 font-black">{{ $item->product_name_snapshot ?? $item->product_name ?? 'UNKNOWN ITEM' }}</td>
                    <td class="px-6 py-5 text-center text-[#BABABA]">Rp{{ number_format($item->product_price_snapshot ?? $item->price ?? 0, 0, ',', '.') }}</td>
                    <td class="px-6 py-5 text-center">{{ $item->quantity }}</td>
                    <td class="px-8 py-5 text-right font-black">Rp{{ number_format(($item->product_price_snapshot ?? $item->price ?? 0) * $item->quantity, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                {{-- INFO RESI DI BAWAH TABEL --}}
                <tr class="bg-[#F9F9F9]/30 border-t border-[#BABABA]/10">
                    <td colspan="4" class="px-8 py-4">
                        <div class="flex items-center gap-2">
                            <span class="text-[9px] font-black text-[#BABABA] uppercase tracking-widest">Tracking Number (J&T):</span>
                            <span class="text-[11px] font-black {{ $transaction->resi_number ? 'text-[#1BCFD5]' : 'text-orange-400 italic' }}">
                                {{ $transaction->resi_number ?? 'NO RESI ASSIGNED YET' }}
                            </span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- ACTION GRID --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        
        {{-- LEFT SIDE: PAYMENT SUMMARY & PROOF --}}
        <div class="space-y-6">
            <h3 class="text-[10px] font-black text-[#BABABA] uppercase tracking-[0.3em] px-2">Payment Details</h3>
            <div class="bg-white border border-[#BABABA]/20 rounded-[2rem] overflow-hidden shadow-sm">
                <table class="min-w-full text-[11px] font-bold uppercase">
                    <tr class="border-b border-[#F9F9F9]">
                        <td class="p-5 text-[#BABABA]">Subtotal Items</td>
                        <td class="p-5 text-right text-[#202020]">Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="border-b border-[#F9F9F9]">
                        <td class="p-5 text-[#BABABA]">Shipping Cost</td>
                        <td class="p-5 text-right text-[#202020]">Rp{{ number_format($transaction->shipping_cost, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="border-b border-[#F9F9F9]">
                        <td class="p-5 text-[#BABABA]">Unique Code</td>
                        <td class="p-5 text-right text-[#1BCFD5]">+{{ $transaction->unique_code }}</td>
                    </tr>
                    <tr class="bg-[#F9F9F9]/50">
                        <td class="p-5 font-black text-[#202020]">Grand Total</td>
                        <td class="p-5 text-right text-xl font-black text-[#CD2828] tracking-tighter">Rp{{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>

            <div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] p-8 shadow-sm">
                <p class="text-[9px] font-black text-[#BABABA] uppercase tracking-[0.3em] mb-4">Payment Proof</p>
                <div class="aspect-video bg-[#F9F9F9] rounded-2xl mb-6 overflow-hidden border border-[#BABABA]/10">
                    @if($transaction->payment_proof)
                        <img src="{{ Storage::url($transaction->payment_proof) }}" class="w-full h-full object-contain mix-blend-multiply">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-[9px] font-black text-[#BABABA] uppercase tracking-widest italic text-center px-4">No Proof Uploaded</div>
                    @endif
                </div>

                {{-- TOMBOL VERIFIKASI --}}
                {{-- SYARAT: Status bukan Cancelled, bukan Delivered, dan status bayar masih Unpaid --}}
                @if($transaction->shipment_status !== 'cancelled' && $transaction->shipment_status !== 'delivered' && $transaction->payment_status === 'unpaid')
                    <form action="{{ route('staff.transactions.updatePayment', $transaction->id) }}" method="POST" class="flex gap-3">
                        @csrf @method('PATCH')
                        <button type="submit" name="payment_status" value="paid" class="flex-1 bg-[#1BCFD5] text-[#FEFEFE] py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:opacity-90 transition-all shadow-sm">Verify Paid</button>
                        <button type="submit" name="payment_status" value="unpaid" class="flex-1 border border-[#CD2828] text-[#CD2828] py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-[#CD2828] hover:text-white transition-all">Reject</button>
                    </form>
                @else
                    {{-- TAMPILAN LOCK JIKA MAKSUDNYA SUDAH SELESAI/BATAL --}}
                    <div class="w-full bg-[#F9F9F9] py-4 rounded-2xl text-center border border-[#BABABA]/10 border-dashed">
                        <p class="text-[9px] font-black text-[#BABABA] uppercase tracking-widest">
                            @if($transaction->shipment_status === 'cancelled') 
                                ORDER CANCELED • ACTION BLOCKED
                            @elseif($transaction->shipment_status === 'delivered')
                                ORDER COMPLETED • ACTION BLOCKED
                            @else
                                PAYMENT ALREADY VERIFIED
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>

        {{-- RIGHT SIDE: SHIPPING INFORMATION --}}
        <div class="space-y-6">
            <h3 class="text-[10px] font-black text-[#BABABA] uppercase tracking-[0.3em] px-2">Shipment Control</h3>
            
            <div class="bg-white border border-[#BABABA]/20 rounded-[2rem] p-6 space-y-4 shadow-sm">
                <div class="flex justify-between items-center border-b border-[#F9F9F9] pb-3">
                    <span class="text-[10px] font-black text-[#BABABA] uppercase tracking-widest">Courrier</span>
                    <span class="font-black text-[#202020] text-xs uppercase tracking-tighter">J&T EXPRESS</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-[10px] font-black text-[#BABABA] uppercase tracking-widest">Shipment Status</span>
                    <span class="text-[10px] font-black text-[#1BCFD5] uppercase tracking-widest">{{ $transaction->shipment_status }}</span>
                </div>
            </div>

            <div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] p-8 shadow-sm">
                <form action="{{ route('staff.transactions.updateStatus', $transaction->id) }}" method="POST" class="space-y-6">
                    @csrf @method('PUT')
                    <div>
                        <label class="text-[9px] font-black text-[#BABABA] uppercase tracking-widest block mb-2 ml-1">Update Logistic Status</label>
                        <select name="shipping_status" {{ $isLocked ? 'disabled' : '' }} class="w-full {{ $isLocked ? 'bg-[#F9F9F9] opacity-50' : 'bg-[#F9F9F9]' }} border-none rounded-xl p-4 font-black text-[11px] text-[#202020] outline-none">
                            <option value="pending" {{ $transaction->shipment_status == 'pending' ? 'selected' : '' }}>PENDING</option>
                            <option value="processing" {{ $transaction->shipment_status == 'processing' ? 'selected' : '' }}>PROCESSING</option>
                            <option value="shipped" {{ $transaction->shipment_status == 'shipped' ? 'selected' : '' }}>SHIPPED</option>
                            <option value="delivered" {{ $transaction->shipment_status == 'delivered' ? 'selected' : '' }}>DELIVERED</option>
                            <option value="cancelled" {{ $transaction->shipment_status == 'cancelled' ? 'selected' : '' }}>CANCELED</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-[#BABABA] uppercase tracking-widest block mb-2 ml-1">J&T Resi Number</label>
                        <input type="text" name="resi_number" value="{{ $transaction->resi_number }}" {{ $isLocked ? 'readonly' : '' }} 
                            class="w-full {{ $isLocked ? 'bg-[#F9F9F9] opacity-50' : 'bg-[#F9F9F9]' }} border-none rounded-xl p-4 font-black text-[11px] tracking-widest uppercase text-[#202020] outline-none" placeholder="INPUT RESI...">
                    </div>
                    
                    {{-- TOMBOL UPDATE: HILANG JIKA LOCKED --}}
                    @if(!$isLocked)
                        <button type="submit" class="w-full bg-[#202020] text-[#FEFEFE] py-4 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#CD2828] transition-all shadow-lg">Save Shipment Update</button>
                    @else
                        <div class="w-full bg-[#F9F9F9] py-4 rounded-2xl text-center border border-[#BABABA]/10 border-dashed">
                            <p class="text-[9px] font-black text-[#BABABA] uppercase tracking-widest">Archive • Transaction Locked</p>
                        </div>
                    @endif
                </form>
            </div>

            @if($transaction->receipt_image)
            <div class="bg-white border border-[#BABABA]/20 rounded-[2rem] p-6 shadow-sm">
                <p class="text-[9px] font-black text-[#BABABA] uppercase tracking-widest mb-4">Buyer Receipt Image</p>
                <img src="{{ Storage::url($transaction->receipt_image) }}" class="w-full h-32 object-cover rounded-xl border border-[#F9F9F9] grayscale hover:grayscale-0 transition-all">
            </div>
            @endif
        </div>
    </div>

    <div class="mt-16 text-center">
        <a href="{{ route('staff.transactions.index') }}" class="text-[9px] font-black text-[#BABABA] uppercase tracking-[0.4em] hover:text-[#202020] transition-all border-b border-[#BABABA] pb-1">Return to List</a>
    </div>
</div>
@endsection