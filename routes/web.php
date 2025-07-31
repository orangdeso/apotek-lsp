<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Customer\TransactionController;
use App\Http\Controllers\Customer\AddressController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\CustomerManagementController;

// URL awal - redirect berdasarkan authentication status
Route::get('/', function () {
    if (Auth::check()) {
        /** @var User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isApoteker()) {
            return redirect()->route('pharmacist.dashboard');
        } else {
            return redirect()->route('customer.dashboard');
        }
    }
    // Jika belum login, tampilkan halaman customer (public)
    return app(CustomerController::class)->dashboard();
})->name('home');

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
            return redirect()->route('admin.dashboard');
        } elseif ($user->isApoteker()) {
            return redirect()->route('pharmacist.dashboard');
        } else {
            return redirect()->route('customer.dashboard');
        }
    })->name('dashboard');
    
    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.admin');
        })->name('dashboard');
        
        // Pharmacist Management Routes
        Route::prefix('pharmacists')->name('pharmacists.')->group(function () {
            Route::get('/', [PharmacistController::class, 'index'])->name('index');
            Route::get('/create', [PharmacistController::class, 'create'])->name('create');
            Route::post('/', [PharmacistController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [PharmacistController::class, 'edit'])->name('edit');
            Route::put('/{id}', [PharmacistController::class, 'update'])->name('update');
            Route::delete('/{id}', [PharmacistController::class, 'destroy'])->name('destroy');
        });
        
        // Customer Management Routes
        Route::prefix('customers')->name('customers.')->group(function () {
            Route::get('/', [CustomerManagementController::class, 'index'])->name('index');
            Route::get('/create', [CustomerManagementController::class, 'create'])->name('create');
            Route::post('/', [CustomerManagementController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [CustomerManagementController::class, 'edit'])->name('edit');
            Route::put('/{id}', [CustomerManagementController::class, 'update'])->name('update');
            Route::delete('/{id}', [CustomerManagementController::class, 'destroy'])->name('destroy');
        });
        
        // Legacy users route (for backward compatibility)
         Route::get('/users', function () {
             return redirect()->route('admin.pharmacists.index');
         })->name('users.index');
         Route::get('/users/create', function () {
             return redirect()->route('admin.pharmacists.create');
         })->name('users.create');
        
        // Supplier Management Routes
        Route::prefix('suppliers')->name('suppliers.')->group(function () {
            Route::get('/', [SupplierController::class, 'index'])->name('index');
            Route::get('/create', [SupplierController::class, 'create'])->name('create');
            Route::post('/', [SupplierController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [SupplierController::class, 'edit'])->name('edit');
            Route::put('/{id}', [SupplierController::class, 'update'])->name('update');
            Route::delete('/{id}', [SupplierController::class, 'destroy'])->name('destroy');
        });
        
        // Drug Management Routes
        Route::prefix('drugs')->name('drugs.')->group(function () {
            Route::get('/', [ObatController::class, 'index'])->name('index');
            Route::get('/create', [ObatController::class, 'create'])->name('create');
            Route::post('/', [ObatController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ObatController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ObatController::class, 'update'])->name('update');
            Route::delete('/{id}', [ObatController::class, 'destroy'])->name('destroy');
        });
        
        // Legacy obat routes (for backward compatibility)
        Route::get('/obat', function () {
            return redirect()->route('admin.drugs.index');
        })->name('obat.index');
        
        Route::post('/obat', [ObatController::class, 'store'])->name('obat.store');
        
        // Sales Management Routes
        Route::prefix('sales')->name('sales.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\SalesController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\SalesController::class, 'create'])->name('create');
            Route::get('/search-products', [\App\Http\Controllers\Admin\SalesController::class, 'searchProducts'])->name('search.products');
            Route::get('/obat/{id}/details', [\App\Http\Controllers\Admin\SalesController::class, 'getObatDetails'])->name('obat.details');
            Route::post('/', [\App\Http\Controllers\Admin\SalesController::class, 'store'])->name('store');
            Route::get('/{id}', [\App\Http\Controllers\Admin\SalesController::class, 'show'])->name('show');
        });
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
