<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\CustomerController;

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
        // Rute untuk transaksi, keranjang, dll yang memerlukan login
    });
});
