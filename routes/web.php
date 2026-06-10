<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\UserController;

// =========================================================================
// 1. PUBLIC ROUTES (Pelapor / Masyarakat)
// =========================================================================

Route::get('/', [TiketController::class, 'index'])->name('home');

Route::get('/form-lapor', function () {
    return view('form-lapor');
})->name('laporan.form');

Route::post('/kirim-laporan', [TiketController::class, 'storeReport'])->name('laporan.store');

Route::get('/kirim-laporan', function () {
    return redirect()->route('laporan.form');
});

Route::get('/sukses-lapor', [TiketController::class, 'sukses'])->name('laporan.sukses');

Route::get('/lacak-status', [TiketController::class,'lacakStatus'])->name('laporan.lacak');


// =========================================================================
// 2. ADMIN ROUTES (Autentikasi & Manajemen)
// =========================================================================

Route::get('/admin/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [UserController::class, 'login'])->name('admin.login.proses');
Route::post('/admin/logout', [UserController::class, 'logout'])->name('admin.logout');

Route::middleware(['admin'])->group(function () {
    
    Route::get('/admin/dashboard', [UserController::class, 'adminDashboard'])->name('admin.dashboard');
    
    Route::get('/admin/pengaduan', [UserController::class, 'adminPengaduan'])->name('admin.pengaduan-user');
    
    Route::patch('/admin/tickets/{id}/update-status', [TiketController::class, 'updateStatus'])->name('admin.tickets.update-status');

    Route::get('/admin/manage-user', [UserController::class, 'userIndex'])->name('admin.manage-user');
    
    Route::post('/admin/users', [UserController::class, 'userStore'])->name('admin.users.store');
    
    Route::put('/admin/users/{id}', [UserController::class, 'userUpdate'])->name('admin.users.update');
    
    Route::delete('/admin/users/{id}', [UserController::class, 'userDestroy'])->name('admin.users.destroy');
    
});