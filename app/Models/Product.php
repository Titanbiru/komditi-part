<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'price',
        'description',
        'discount',
        'is_promo',
        'stock',
        'weight',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'is_promo' => 'boolean',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // app/Models/Product.php

    public function getThumbnailAttribute()
    {
        // 1. Ambil data gambar pertama dari relasi product_images
        $firstImage = $this->images->first();

        if (!$firstImage) {
            return asset('images/no-image.png'); // Gambar default kalau di DB kosong
        }

        $path = $firstImage->image_path;

        // 2. Cek apakah file ada di public/storage/products/
        if (file_exists(public_path('storage/' . $path))) {
            return asset('storage/' . $path);
        }

        // 3. Cek apakah file ada di public/uploads/ (atau folder lain sesuai DB)
        if (file_exists(public_path($path))) {
            return asset($path);
        }

        // 4. Kalau semua gagal, return path mentah atau placeholder
        return asset($path);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id');
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function stockHistories()
    {
        return $this->hasMany(StockHistory::class)->latest();
    }

    public function favoritedBy()
    {
        
        return $this->belongsToMany(User::class, 'favorites', 'product_id', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
