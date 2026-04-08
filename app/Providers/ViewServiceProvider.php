<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Models\Cart; // Sesuaikan dengan nama model Cart Mas
use App\Models\Favorite; // Sesuaikan dengan nama model Favorite Mas
use App\Models\CartItem; // Sesuaikan dengan nama model CartItem Mas

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void 
    { 
        $file = app_path('Helpers/settings.php');
        if (file_exists($file)) {
            require_once $file;
        }
    }

    public function boot(): void
    {
        // Menyuntikkan data ke file header (sesuaikan path filenya)
        View::composer('components.header', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                
                // Hitung Favorit
                $favoritesCount = $user->favorites()->count();
                
                // Hitung Keranjang (Asumsi Mas pakai model Cart atau relasi cart di User)
                // Jika Mas pakai session untuk cart, sesuaikan logikanya di sini
                $cartCount = $user->cartItems()->sum('quantity'); // Asumsi relasi cart memiliki field quantity di CartItem

                $view->with([
                    'favoritesCount' => $user->favorites()->count(),
                    'cartCount' => $cartCount
                ]);
            } else {
                $view->with([
                    'favoritesCount' => 0,
                    'cartCount' => 0
                ]);
            }
        });

        View::composer(['layouts.public', 'layouts.user'], function ($view) {
            
            // Jika Controller SUDAH mengirim $breadcrumbs, pakai yang itu (Prioritas Manual)
            if ($view->offsetExists('breadcrumbs')) {
                return;
            }

            // Jika TIDAK ADA, kita buatkan otomatis berdasarkan URL (Auto-Generate)
            $breadcrumbs = [];
            $segments = Request::segments();
            $url = '';

            foreach ($segments as $segment) {
                $url .= '/' . $segment;
                // Ubah tulisan URL jadi rapi (misal: 'product-category' jadi 'Product Category')
                $name = ucwords(str_replace(['-', '_'], ' ', $segment));
                // Abaikan ID atau Slug yang berupa angka/kode panjang (opsional)
                if (strlen($segment) > 20) continue; 
                $breadcrumbs[] = [
                    'name' => ucwords(str_replace(['-', '_'], ' ', $segment)),
                    'url' => url($url)
                ];
            }

            $view->with('breadcrumbs', $breadcrumbs);
        });
    }
}