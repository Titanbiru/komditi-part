@extends('layouts.admin')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Stock History</h1>
        <p class="text-gray-500 uppercase font-bold text-sm mt-1">{{ $product->name }} ({{ $product->sku }})</p>
    </div>
    <a href="{{ route('staff.stock.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 font-bold rounded-full hover:bg-gray-300 transition-all flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Back to Stock
    </a>
</div>

<div class="bg-white rounded-2xl shadow-md border-2 border-black overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-100 border-b-2 border-black">
            <tr>
                <th class="px-6 py-4 text-left text-sm font-black uppercase">Date & Time</th>
                <th class="px-6 py-4 text-left text-sm font-black uppercase">Staff</th>
                <th class="px-6 py-4 text-left text-sm font-black uppercase">Type</th>
                <th class="px-6 py-4 text-left text-sm font-black uppercase">Amount</th>
                <th class="px-6 py-4 text-left text-sm font-black uppercase">Stock Change</th>
                <th class="px-6 py-4 text-left text-sm font-black uppercase">Note</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($histories as $h)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm font-medium text-gray-600">
                    {{ $h->created_at->format('d M Y, H:i') }}
                </td>
                <td class="px-6 py-4 text-sm font-bold text-gray-800">
                    {{ $h->user->name ?? 'System' }}
                </td>
                <td class="px-6 py-4">
                    @if($h->type == 'in')
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-black uppercase">Incoming</span>
                    @else
                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-[10px] font-black uppercase">Outgoing</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm font-black {{ $h->type == 'in' ? 'text-green-600' : 'text-red-600' }}">
                    {{ $h->type == 'in' ? '+' : '-' }}{{ $h->amount }}
                </td>
                <td class="px-6 py-4 text-sm">
                    <span class="text-gray-400">{{ $h->stock_before }}</span> 
                    <span class="mx-2 font-bold">→</span> 
                    <span class="font-black text-gray-900">{{ $h->stock_after }}</span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 italic">
                    {{ $h->note ?? '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-10 text-gray-400 italic">No history found for this product.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $histories->links() }}
</div>
@endsection