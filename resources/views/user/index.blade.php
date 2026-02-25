@extends ('layouts.user')

@section('content')
    <h1>Selamat datang di dashboard user</h1>
    <p>Ini adalah halaman dashboard untuk user yang telah login. Kamu bisa melihat produk favoritmu, mengelola keranjang belanja, dan melihat riwayat transaksi kamu di sini.</p>
    <p>Silakan jelajahi fitur-fitur yang tersedia dan nikmati pengalaman berbelanja di Komditi!</p>
    <p>
kamu login user

<!-- logout -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Logout</button>
    </form>
@endsection