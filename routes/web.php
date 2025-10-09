<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\kantin;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('landpage');
});



// Login Pembeli
Route::get('/login/pembeli', [AuthController::class, 'showLoginPembeli'])->name('login.pembeli');
Route::post('/login/pembeli', [AuthController::class, 'loginPembeli']);

// Login Penjual
Route::get('/login/penjual', [AuthController::class, 'showLoginPenjual'])->name('login.penjual');
Route::post('/login/penjual', [AuthController::class, 'loginPenjual']);

// Login Admin
Route::get('/login/admin', [AuthController::class, 'showLoginAdmin'])->name('login.admin');
Route::post('/login/admin', [AuthController::class, 'loginAdmin']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout']); // Tambahan untuk GET method

// Dashboard Pembeli (Protected)
Route::get('/home', function () {
    // Cek apakah user sudah login
    if (!session('logged_in')) {
        return redirect('/login/pembeli');
    }
    return view('home');
})->name('dashboard.pembeli');

// Dashboard Penjual (Protected)
Route::get('/penjual/dashboard', function () {
    if (!session('logged_in') || session('role') !== 'penjual') {
        return redirect('/login/penjual');
    }
    return view('penjual.dashboard');
})->name('dashboard.penjual');

// Dashboard Admin (Protected)
Route::get('/admin/dashboard', function () {
    if (!session('logged_in') || session('role') !== 'admin') {
        return redirect('/login/admin');
    }
    return view('admin.dashboard');
})->name('dashboard.admin');
