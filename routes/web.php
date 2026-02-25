<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

// public controllers
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ProductController; 
use App\Http\Controllers\Public\ContactController;

//admin Controllers 
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController; 
use App\Http\Controllers\Admin\ProductController as adminProductController; 
use App\Http\Controllers\Admin\UserController; 
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController; 
use App\Http\Controllers\Admin\ReportController as AdminReportController; 
use App\Http\Controllers\Admin\BackupController; 
// staff controllers 
use App\Http\Controllers\StaffController; 
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController; 
use App\Http\Controllers\Staff\ProductController as StaffProductController; 
use App\Http\Controllers\Staff\TransactionController as StaffTransactionController; 
use App\Http\Controllers\Staff\StockController as StaffStockController; 
use App\Http\Controllers\Staff\ReportController as StaffReportController; 
// user controllers 
use App\Http\Controllers\User\CartController; 
use App\Http\Controllers\User\CheckoutController; 
use App\Http\Controllers\User\OrderController; 
use App\Http\Controllers\User\TransactionController; 
use App\Http\Controllers\User\FavoriteController;

// Landing Page
Route::get('/', [HomeController::class, 'index'])->name('landing');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

// Public product view (guest boleh lihat)
Route::get('/search', [ProductController::class, 'search'])->name('search');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/show', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');

// CUSTOMER ROUTES (Login Required)
Route::middleware(['auth', 'role:user'])->group(function () {

    Route::get('/public', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    Route::get('/favorite', [FavoriteController::class, 'favorites'])->name('favorites.index');
    Route::post('/favorite/add/{product}', [FavoriteController::class, 'add'])->name('favorites.add');
    Route::delete('/favorite/remove/{product}', [FavoriteController::class, 'remove'])->name('favorites.remove');

    Route::get('/profile', [TransactionController::class, 'index'])->name('profile.index');


    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});


// ADMIN ROUTES

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('users', UserController::class);
        
        Route::resource('products', AdminProductController::class)
            ->only(['index','show', 'edit', 'update']);

        Route::get('/transactions/{order}', [AdminTransactionController::class, 'show'])
            ->name('transactions.show');

        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [AdminReportController::class, 'index'])->name('index');
            Route::get('/sales', [AdminReportController::class, 'sales'])->name('sales');
            Route::get('/stocks', [AdminReportController::class, 'products'])->name('stocks');
            Route::get('/transactions', [AdminReportController::class, 'transactions'])->name('transactions');
            Route::get('/export', [AdminReportController::class, 'exportPdf'])->name('export');
        });

        Route::prefix('backup')->name('backup.')->group(function () {
            Route::get('/', [BackupController::class, 'index'])->name('index');
            Route::post('/create', [BackupController::class, 'create'])->name('create');
            Route::post('/restore', [BackupController::class, 'restore'])->name('restore');
        });
});


// STAFF ROUTES

Route::prefix('staff')
    ->name('staff.')
    ->middleware(['auth', 'role:staff'])
    ->group(function () {

        Route::get('/dashboard', [StaffDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('products', StaffProductController::class)
            ->only(['index','show']);

        Route::get('/stock', [StaffStockController::class, 'index'])->name('stock.index');
        Route::put('/stock/{product}', [StaffStockController::class, 'update'])->name('stock.update');

        Route::get('/transactions', [StaffTransactionController::class, 'index'])->name('transactions.index');
        Route::get('/transactions/{order}', [StaffTransactionController::class, 'update'])->name('transactions.update');

        Route::get('/report', [StaffReportController::class, 'index'])->name('report.index');
});