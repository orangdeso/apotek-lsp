<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registration Routes (opsional)
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

// Authentication Routes
// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');

// Route::post('/login', function () {
//     // Logic untuk proses login
//     return redirect()->route('dashboard');
// })->name('login.process');

// Route::get('/register', function () {
//     return view('auth.register');
// })->name('register');

// Route::post('/register', function () {
//     // Logic untuk proses register
//     return redirect()->route('dashboard');
// })->name('register.process');

// Route::post('/logout', function () {
//     // Logic untuk logout
//     return redirect()->route('login');
// })->name('logout');