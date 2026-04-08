<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua order milik user, filter berdasarkan status jika ada
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.product.images'])
            ->latest()
            ->paginate(5);

        $breadcrumbs = [
                ['name' => 'Akun Saya', 'url' => route('user.account.profile')],
                ['name' => 'Riwayat Pesanan', 'url' => null],
            ];
        return view('user.account.orders.index', compact('orders', 'breadcrumbs'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product'])->where('user_id', Auth::id())->findOrFail($id);

        $breadcrumbs = [
            ['name' => 'Akun Saya', 'url' => route('user.account.profile')],
            ['name' => 'Riwayat Pesanan', 'url' => route('user.account.orders')],
            ['name' => 'Detail ' . $order->order_number, 'url' => null],
        ];
        return view('user.account.orders.show', compact('order', 'breadcrumbs'));
    }

    // FUNGSI KONFIRMASI BARANG SAMPAI
    public function markAsDelivered(Request $request, $id) // Tambahkan Request $request
    {
        $order = Order::where('user_id', Auth::id())
            ->where('shipment_status', 'shipped')
            ->findOrFail($id);

        // Validasi gambar (Optional tapi disarankan)
        $request->validate([
            'receipt_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'shipment_status' => 'delivered',
            'delivered_at'    => now(), // Bagus buat tracking kapan barang sampai
        ];

        // Logika Simpan Gambar
        if ($request->hasFile('receipt_image')) {
            // Simpan ke folder storage/app/public/receipts
            $path = $request->file('receipt_image')->store('receipts', 'public');
            $data['receipt_image'] = $path; 
        }

        $order->update($data);

        return back()->with('success', 'Terima kasih! Pesanan telah selesai dan bukti telah diunggah.');
    }

    public function cancel($id)
    {
        // 1. Cari pesanan milik user tsb
        $order = Order::where('user_id', Auth::id())->find($id);

        // 2. Kalau pesanan gak ada, balikkan ke riwayat
        if (!$order) {
            return redirect()->route('user.account.orders')->with('error', 'Pesanan tidak ditemukan, Mas.');
        }

        // 3. Cek apakah statusnya MASIH bisa di-cancel (Pending & Belum Bayar)
        if ($order->shipment_status !== 'pending' || $order->payment_status !== 'unpaid') {
            return redirect()->route('user.account.orders')->with('error', 'Wah, pesanan ini sudah diproses atau sudah dibayar, jadi nggak bisa dibatalin euy.');
        }

        // 4. Proses Cancel
        $order->update([
            'shipment_status' => 'cancelled',
        ]);

        // 5. Balik ke halaman riwayat dengan pesan sukses
        return redirect()->route('user.account.orders')->with('success', 'Sae! Pesanan berhasil dibatalkan.');
    }
    public function history()
    {
        $orders = Order::with(['items.product'])
            ->where('user_id', Auth::id())
            ->whereIn('payment_status', ['paid', 'cancelled'])
            ->latest()
            ->paginate(10);

        $breadcrumbs = [
            ['name' => 'Akun Saya', 'url' => route('user.account.profile')],
            ['name' => 'Riwayat Pesanan', 'url' => null],
        ];

        return view('orders.history', compact('orders', 'breadcrumbs'));
    }

    public function invoice($id)
    {
        // Pastikan user cuma bisa cetak invoice miliknya sendiri
        $order = Order::with(['items.product'])->where('user_id', Auth::id())->findOrFail($id);
        
        // Panggil file invoice polos yang udah Mas bikin buat admin/staff
        // (Sesuaikan path-nya dengan letak file HTML murni tadi)
        return view('admin.reports.invoice', compact('order')); 
    }
}