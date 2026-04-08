<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\ForgotPasswordController;

// public controllers
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ProductController; 
use App\Http\Controllers\Public\ContactController;

//admin Controllers 
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController; 
use App\Http\Controllers\Admin\UserController as AdminUserController; 
use App\Http\Controllers\Admin\ProductController as AdminProductController; 
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController; 
use App\Http\Controllers\Admin\OrderController as AdminOrderController; 
use App\Http\Controllers\Admin\ReportController as AdminReportController; 
use App\Http\Controllers\Admin\BackupController; 
use App\Http\Controllers\Admin\SettingController; 

// staff controllers 
use App\Http\Controllers\StaffController; 
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController; 
use App\Http\Controllers\Staff\ProductController as StaffProductController; 
use App\Http\Controllers\Staff\OrderController as StaffOrderController; 
use App\Http\Controllers\Staff\StockController as StaffStockController; 
use App\Http\Controllers\Staff\ReportController as StaffReportController; 
// user controllers 
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\CartController; 
use App\Http\Controllers\User\CheckoutController; 
use App\Http\Controllers\User\OrderController; 
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\FavoriteController;
use App\Http\Controllers\User\SettingsController;
use App\Http\Controllers\User\AddressController;
use App\Http\Controllers\User\PaymentController;


// Landing Page
Route::get('/', [HomeController::class, 'index'])->name('public.index');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
->middleware('auth')
->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

// Public product view (guest boleh lihat)
Route::get('/search', [ProductController::class, 'search'])->name('search');
Route::get('/products', [ProductController::class, 'index'])->name('public.products');

// Halaman produk berdasarkan kategori (untuk fix error kamu)
Route::get('/category/{slug}', [ProductController::class, 'category'])->name('public.category');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('public.products.show');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');

// CUSTOMER ROUTES (Login Required)
Route::middleware(['auth', 'role:user'])->group(function () {

    Route::get('/user', function () {return view('user.index');})->name('index');

    Route::get('/favorites', [FavoriteController::class, 'index'])->name('user.account.favorites');
    Route::post('/favorites/{product}', [FavoriteController::class, 'store'])->name('user.account.favorites.store');
    Route::delete('/favorites/{product}', [FavoriteController::class, 'destroy'])->name('user.account.favorites.destroy');
    Route::post('/favorites/toggle/{productId}', [FavoriteController::class, 'toggle'])->name('user.account.favorites.toggle');

    Route::get('/profile', [ProfileController::class, 'index'])->name('user.account.profile');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('user.account.profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('user.account.profile.update.password');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('user.account.profile.delete');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/update/{itemId}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/item/{itemId}', [CartController::class, 'removeFromCart'])->name('cart.remove');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    // Route::get('/checkout', [CheckoutController::class, 'index'])->middleware(['auth', 'verified']);

    Route::get('/orders', [OrderController::class, 'index'])->name('user.account.orders');
    Route::get('/orders/history', [OrderController::class, 'history'])->name('user.account.orders.history');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('user.account.orders.show');
    Route::put('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('user.account.orders.cancel');
    Route::put('/orders/{id}/delivered', [OrderController::class, 'markAsDelivered'])->name('user.account.orders.delivered');
    Route::get('/account/orders/{id}/invoice', [OrderController::class, 'invoice'])->name('user.account.orders.invoice');

    Route::get('/addresses', [AddressController::class, 'index'])->name('user.account.addresses');
    Route::get('/addresses/create', [AddressController::class, 'create'])->name('user.account.addresses.create');
    Route::post('/addresses', [AddressController::class, 'store'])->name('user.account.addresses.store');
    Route::get('/addresses/{id}/edit', [AddressController::class, 'edit'])->name('user.account.addresses.edit');
    Route::put('/addresses/{id}', [AddressController::class, 'update'])->name('user.account.addresses.update');
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy'])->name('user.account.addresses.destroy');

});


// ADMIN ROUTES

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
        Route::put('/profile/password', [AdminUserController::class, 'updateAdmin'])->name('profile.update');
        
        Route::resource('categories', AdminCategoryController::class);
        Route::get('categories', [AdminCategoryController::class, 'index'])->name('categories.index');
        
        Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
        Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}', [AdminProductController::class, 'show'])->name('products.show');
        Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
        Route::delete('/products/image/{id}', [AdminProductController::class, 'deleteImage'])->name('products.delete_image');
        Route::delete('/products/{products}', [AdminProductController::class, 'destroy'])->name('products.destroy');

        Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/sales', [AdminReportController::class, 'sales'])->name('reports.sales');
        Route::get('/reports/stocks', [AdminReportController::class, 'stock'])->name('reports.stocks');
        Route::get('/reports/transactions', [AdminReportController::class, 'transactions'])->name('reports.transactions');
        Route::get('/reports/transactions/{order}', [AdminReportController::class, 'transactionShow'])->name('reports.transactions-show');
        Route::get('/reports/invoice/{order}', [AdminReportController::class, 'invoice'])->name('reports.invoice');
        Route::get('/sales/pdf', [AdminReportController::class, 'exportSalesPdf'])->name('reports.sales.pdf');
        Route::get('/stocks/pdf', [AdminReportController::class, 'exportStocksPdf'])->name('reports.stocks.pdf');
        Route::get('/transactions/pdf', [AdminReportController::class, 'exportTransactionsPdf'])->name('reports.transactions.pdf');
        Route::get('/reports/stocks_history/{product}', [AdminReportController::class, 'stocksHistory'])->name('reports.stocks_history');

        Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
        Route::post('/generate', [BackupController::class, 'backup'])->name('backup.generate');
        Route::get('/download/{filename}', [BackupController::class, 'download'])->name('backups.download');
        Route::delete('/delete/{filename}', [BackupController::class, 'delete'])->name('backups.delete');
        Route::post('/restore', [BackupController::class, 'restore'])->name('backup.restore');

        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

});


// STAFF ROUTES

Route::prefix('staff')
    ->name('staff.')
    ->middleware(['auth', 'role:staff'])
    ->group(function () {

        Route::get('/dashboard', [StaffDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/products', [StaffProductController::class, 'index'])->name('products.index');
        Route::get('/products/{product}', [StaffProductController::class, 'show'])->name('products.show');

        Route::get('/stock', [StaffStockController::class, 'index'])->name('stock.index');
        Route::get('/stock/{product}/edit', [StaffStockController::class, 'edit'])->name('stock.edit');
        Route::put('/stock/{product}', [StaffStockController::class, 'update'])->name('stock.update');
        Route::get('/stock/{product}/history', [StaffStockController::class, 'history'])->name('stock.history');

        Route::get('/transactions', [StaffOrderController::class, 'index'])->name('transactions.index');
        Route::get('/transactions/{id}/edit', [StaffOrderController::class, 'edit'])->name('transactions.edit');
        Route::get('/transactions/{id}', [StaffOrderController::class, 'show'])->name('transactions.show');
        Route::patch('/transactions/{id}/payment', [StaffOrderController::class, 'updatePayment'])->name('transactions.updatePayment');
        Route::put('/transactions/{id}/status', [StaffOrderController::class, 'updateStatus'])->name('transactions.updateStatus');

        Route::get('/reports', [StaffReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/sales', [StaffReportController::class, 'sales'])->name('reports.sales');
        Route::get('/reports/stocks', [StaffReportController::class, 'stock'])->name('reports.stocks');
        Route::get('/reports/transactions', [StaffReportController::class, 'transactions'])->name('reports.transactions');
        Route::get('/reports/transactions/{order}', [StaffReportController::class, 'transactionShow'])->name('reports.transaction_detail');

});