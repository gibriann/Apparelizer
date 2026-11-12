<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardProductController;
use App\Http\Controllers\DashboardTransactionController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::post('/postlogin', [AuthController::class, 'postlogin'])->name('postlogin');
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::get('/logout', [AuthController::class, 'logout']);

Route::post('/postregister', [AuthController::class, 'postregister'])->name('postregister');
Route::get('/register', [AuthController::class, 'register'])->name('register');

Route::post('reset-password', [AuthController::class, 'submitResetPasswordForm'])->name('reset.password.post');
Route::post('lupa-password', [AuthController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::get('lupa-password', [AuthController::class, 'showForgetPasswordForm'])->name('forget.password.get');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/details/{id}/{slug}', [DetailsController::class, 'index'])->name('details');
Route::get('/register/success', [App\Http\Controllers\Auth\RegisterController::class, 'success'])->name('register-success');
Route::post('/checkout/callback', [CartController::class, 'callback'])->name('midtrans-callback');

Route::post('/cart/{id}/{slug}', [CartController::class, 'store']);

Route::middleware(['auth','checkrole: 3'])->group(function () {
    Route::post('/cart/delete/{id}', [CartController::class, 'delete']);
    
    // New RajaOngkir API V2 endpoints
    Route::get('/shipping/search-destination', [CartController::class, 'searchDestination']);
    Route::post('/shipping/calculate-cost', [CartController::class, 'calculateCost']);
    
    Route::post('/checkout', [CartController::class, 'storePayment'])->name('checkout');
    Route::post('/account', [AccountController::class, 'update']);
    
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/shipping', [CartController::class, 'buy'])->name('buy');
    Route::get('/success', [CartController::class, 'success'])->name('success');
    Route::get('/account', [AccountController::class, 'account'])->name('account');

    Route::post('/account/addresses', [AccountController::class, 'addressStore'])->name('account-address-store');
    Route::put('/account/addresses/{id}', [AccountController::class, 'addressUpdate'])->name('account-address-update');
    Route::delete('/account/addresses/{id}', [AccountController::class, 'addressDestroy'])->name('account-address-delete');
    Route::post('/account/addresses/{id}/default', [AccountController::class, 'addressSetDefault'])->name('account-address-default');
    Route::get('/history', [TransactionController::class, 'history'])->name('history');
    Route::get('/transactions/{id}/details', [TransactionController::class, 'show'])->name('transaction-details');
});

// Deprecated old RajaOngkir endpoints (kept for backward compatibility)
Route::get('/cart/dataprovinsi', [CartController::class, 'province'])->middleware(['auth','checkrole: 3']);
Route::get('/rajaongkir/provinsi/{idProvinsi}/distrik', [CartController::class, 'district']);
Route::get('/rajaongkir/ekspedisi/{ekspedisi_terpilih}/distrik/{distrik_terpilih}/berat/{total_weight}', [CartController::class, 'options']);

Route::middleware(['auth','checkrole: 2'])->group(function () {
    Route::post('/dashboard/reports/periode', [DashboardController::class, 'periode']);
    Route::post('/dashboard/reports/date', [DashboardController::class, 'date']);
    Route::get('/dashboard/reports', [DashboardController::class, 'report'])->name('dashboard-reports');
});

Route::middleware(['auth','checkrole: 1,2'])->group(function () {
    Route::post('/dashboard/account', [AccountController::class, 'update']);

    Route::post('/dashboard/products/store', [DashboardProductController::class, 'store'])->name('dashboard-product-store');
    Route::post('/dashboard/products/{id}', [DashboardProductController::class, 'update']);
    Route::get('/dashboard/products/{id}/hapus', [DashboardProductController::class, 'delete']);
    Route::get('/dashboard/products/{id}/details', [DashboardProductController::class, 'details'])->name('dashboard-product-details');
    Route::get('/dashboard/products/add', [DashboardProductController::class, 'add'])->name('dashboard-product-add');
    Route::get('/dashboard/products', [DashboardProductController::class, 'index'])->name('dashboard-products');

    Route::post('/dashboard/admins/{id}/status', [AccountController::class, 'adminUpdateStatus']);
    Route::post('/dashboard/admins/{id}/ubah', [AccountController::class, 'adminUpdate']);
    Route::post('/dashboard/admins/store', [AccountController::class, 'adminStore'])->name('dashboard-admin-store');
    Route::get('/dashboard/admins/create', [AccountController::class, 'adminCreate'])->name('dashboard-admin-add');
    Route::get('/dashboard/admins', [AccountController::class, 'adminList'])->name('dashboard-admins');

    Route::post('/dashboard/{id}/status', [AccountController::class, 'updateStatusUser']);
    Route::get('/dashboard/customers', [AccountController::class, 'customerList'])->name('dashboard-customers');

    Route::post('/dashboard/transactions/{id}/resi', [DashboardTransactionController::class, 'resi']);
    Route::post('/dashboard/transactions/{id}/detail', [DashboardTransactionController::class, 'update']);
    Route::get('/dashboard/transactions/{id}/customer', [DashboardTransactionController::class, 'detailCustomer']);
    Route::get('/dashboard/transactions/{id}/detail', [DashboardTransactionController::class, 'show'])->name('dashboard-transaction-details');
    Route::get('/dashboard/transactions', [DashboardTransactionController::class, 'index'])->name('dashboard-transactions');

    Route::get('/dashboard/account', [AccountController::class, 'adminAccount'])->name('dashboard-account');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
