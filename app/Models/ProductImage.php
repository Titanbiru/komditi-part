<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use HasFactory;

    // 1. Daftarkan kolom yang ada di database
    protected $fillable = [
        'product_id',
        'image_path'
    ];

    /**
     * 2. Relasi Balik ke Product
     * Artinya: Setiap foto ini milik satu produk tertentu.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
