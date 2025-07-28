<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Customer\TransactionController;
use App\Http\Controllers\Customer\AddressController;

// URL awal menampilkan dashboard customer (tanpa login)
Route::get('/', [CustomerController::class, 'dashboard'])->name('home');

// Rute publik untuk customer (tanpa login)
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('/obat', [CustomerController::class, 'obatIndex'])->name('obat.index');
    Route::get('/obat/{id}', [CustomerController::class, 'obatShow'])->name('obat.show');
});

// Include auth routes
require __DIR__.'/auth.php';

// Protected routes dengan middleware auth
Route::middleware(['auth'])->group(function () {
    // Dashboard umum (redirect berdasarkan role)
    Route::get('/dashboard', function () {
        /** @var User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('dashboard.admin');
        } elseif ($user->isApoteker()) {
            return redirect()->route('dashboard.pharmacist');
        } else {
            return redirect()->route('dashboard.customer');
        }
    })->name('dashboard');
    
    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.admin');
        })->name('dashboard');
        
        // CRUD routes untuk admin
        Route::get('/users', function () {
            return view('admin.users.index');
        })->name('users.index');
        
        Route::get('/suppliers', function () {
            return view('admin.suppliers.index');
        })->name('suppliers.index');
        
        Route::get('/obat', function () {
            return view('admin.obat.index');
        })->name('obat.index');
    });
    
    // Apoteker routes
    Route::middleware(['role:apoteker'])->prefix('pharmacist')->name('pharmacist.')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.pharmacist');
        })->name('dashboard');
        
        Route::get('/obat', function () {
            return view('pharmacist.obat.index');
        })->name('obat.index');
        
        Route::get('/resep', function () {
            return view('pharmacist.resep.index');
        })->name('resep.index');
        
        Route::get('/laporan', function () {
            return view('pharmacist.laporan.index');
        })->name('laporan.index');
        
        Route::get('/penjualan', function () {
            return view('pharmacist.penjualan.index');
        })->name('penjualan.index');
    });
    
    // Customer routes yang memerlukan login
    Route::middleware(['role:pelanggan'])->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
        Route::get('/riwayat', function () {
            return view('customer.riwayat.index');
        })->name('riwayat.index');
        Route::get('/profile', function () {
            return view('customer.profile.index');
        })->name('profile.index');
        
        // Cart routes (moved to global auth group to avoid duplication)
        
        // Checkout route
        Route::get('/checkout', [CustomerController::class, 'checkout'])->name('checkout');
    });
    
    // Cart routes untuk semua authenticated users (tidak hanya pelanggan)
    Route::prefix('customer/cart')->name('customer.cart.')->group(function () {
        Route::post('/add/{id}', [CustomerController::class, 'addToCart'])->name('add');
        Route::get('/', [CustomerController::class, 'viewCart'])->name('view');
        Route::get('/count', [CustomerController::class, 'getCartCount'])->name('count');
        Route::put('/update/{cartId}', [CustomerController::class, 'updateCartItem'])->name('update');
        Route::delete('/remove/{cartId}', [CustomerController::class, 'removeFromCart'])->name('remove');
        Route::delete('/clear', [CustomerController::class, 'clearCart'])->name('clear');
    });
    
    // Checkout route untuk semua authenticated users
    Route::get('/customer/checkout', [CustomerController::class, 'checkout'])->name('customer.checkout');
    
    // Transaction routes
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::post('/checkout/process', [TransactionController::class, 'processCheckout'])->name('checkout.process');
        Route::get('/order/confirmation/{id}', [TransactionController::class, 'confirmation'])->name('orders.confirmation');
        Route::get('/orders', [TransactionController::class, 'history'])->name('orders.history');
        Route::get('/order/{id}', [TransactionController::class, 'show'])->name('orders.detail');
        Route::post('/order/{id}/cancel', [TransactionController::class, 'cancel'])->name('orders.cancel');
        Route::get('/order/{id}/status', [TransactionController::class, 'getOrderStatus'])->name('orders.status');
        
        // Address routes
        Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
        Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
        Route::get('/addresses/{id}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
        Route::put('/addresses/{id}', [AddressController::class, 'update'])->name('addresses.update');
        Route::delete('/addresses/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');
        Route::post('/addresses/{id}/set-default', [AddressController::class, 'setDefault'])->name('addresses.setDefault');
        Route::get('/addresses/get', [AddressController::class, 'getAddresses'])->name('addresses.get');
    });
});
