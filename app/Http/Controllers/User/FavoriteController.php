<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        // Tetap seperti punya Mas, sudah bagus
        $favorites = Auth::user()
            ->favorites()
            ->where('status', 'active') // Pastikan hanya produk aktif yang ditampilkan
            ->with(['images', 'categories']) // Eager load biar ga lambat
            ->latest()
            ->paginate(12);
            
        $breadcrumbs = [
                ['name' => 'Akun Saya', 'url' => route('user.account.profile')],
                ['name' => 'Produk Saya (Favorit)', 'url' => null],
            ];
        return view('user.account.favorites.index', compact('favorites', 'breadcrumbs'));
    }

    // Ganti store & destroy jadi toggle biar simpel buat tombol AJAX
    public function toggle($productId)
    {
        $product = Product::findOrFail($productId);

        $user = Auth::user();
        
        // Cek apakah sudah ada di favorit
        $exists = $user->favorites()->where('product_id', $productId)->exists();

        if ($exists) {
            // Kalau ada, kita hapus (Unlike)
            $user->favorites()->detach($productId); 
            $status = 'removed';
        } else {
            // Kalau tidak ada, kita tambah (Like)
            $user->favorites()->syncWithoutDetaching([$productId]);
            $status = 'added';
        }

        // Ambil jumlah favorit terbaru untuk produk ini (social proof)
        // Pastikan di model Product ada relasi 'favoritedBy'
        $count = \App\Models\Product::find($productId)->favoritedBy()->count();

        return response()->json([
            'status' => $status,
            'count' => $count,
            'message' => $status == 'added' ? 'Ditambahkan ke favorit' : 'Dihapus dari favorit'
        ]);
    }

    // Tetap sediakan destroy manual untuk tombol "Hapus" di halaman daftar favorit
    public function destroy($productId)
    {
        Auth::user()->favorites()->detach($productId);
        return back()->with('success', 'Produk dihapus dari daftar favorit');
    }
}
