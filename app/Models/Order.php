<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_price',      // Harga barang saja (Subtotal)
        'shipping_cost',    // Ongkir yang dipilih
        'admin_fee',        // Biaya admin (Rp 2.500)           // Path foto bukti pembayaran
        'unique_code',      // Kode unik (3 digit terakhir)
        'grand_total',      // Total akhir (semua dijumlah)
        'shipping_name',    // Nama penerima
        'shipping_phone',   // No telp penerima
        'shipping_address', // Alamat lengkap
        'notes',            // Catatan untuk kurir
        'payment_method',   // qris / jago
        'payment_proof',    // Path foto bukti transfer
        'shipment_status',  // pending, proccess, shipped, delivered
        'payment_status',   // waiting_verification, paid, failed
        'shipping_snapshot',// Data backup kurir (Array)
        'resi_number',      // No resi dari kurir (bisa null)
        'receipt_image',    // Path foto bukti delivered
        'delivered_at',     // Timestamp ketika pesanan diterima
    ];

    protected $casts = [
        'shipping_snapshot' => 'array',
        'total_price' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'admin_fee' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'delivered_at' => 'datetime',
    ];

    // RELASI
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}