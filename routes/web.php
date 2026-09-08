<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Redirect dari halaman utama (/) dan Fallback Home Route
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        if ($role === 'admin_master' || $role === 'admin') {
            return redirect()->route('admin.aset');
        } elseif ($role === 'mahasiswa') {
            return redirect()->route('mahasiswa.dashboard');
        } elseif ($role === 'pegawai') {
            return redirect()->route('pegawai.dashboard');
        }
    }
    return redirect()->route('login');
});

// Alias Fallback Routes untuk mencegah 404 Not Found
Route::get('/home', fn() => redirect('/'));
Route::get('/admin/dashboard', fn() => redirect('/'));

// Route Publik Detail Aset (Dapat diakses saat QR Code di-scan)
Route::get('/aset/{id}', [AdminController::class, 'publicDetail'])->name('aset.public_detail')->where('id', '.*');

// Route untuk Tamu (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route untuk User (Sudah Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin & Admin Master Routes (Fitur Operasional)
    Route::middleware('role:admin_master,admin')->group(function () {
        Route::get('/admin/aset', [AdminController::class, 'aset'])->name('admin.aset');
        Route::get('/admin/aset/export-pdf', [AdminController::class, 'exportLaporanPdf'])->name('admin.aset.laporan.pdf');
        Route::post('/admin/aset', [AdminController::class, 'storeAset'])->name('admin.aset.store');
        Route::put('/admin/aset/{no_reg_pemda}', [AdminController::class, 'updateAset'])->name('admin.aset.update')->where('no_reg_pemda', '.*');
        Route::delete('/admin/aset/{no_reg_pemda}', [AdminController::class, 'destroyAset'])->name('admin.aset.destroy')->where('no_reg_pemda', '.*');
        Route::post('/admin/peminjaman/{id}/status', [AdminController::class, 'updateStatusPeminjaman'])->name('admin.peminjaman.update');

        Route::get('/admin/magang', [AdminController::class, 'magang'])->name('admin.magang');
        Route::post('/admin/magang/{id}/status', [AdminController::class, 'updateStatusMagang'])->name('admin.magang.update');
    });

    // Khusus Admin Master (Manajemen User)
    Route::middleware('role:admin_master')->group(function () {
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.user');
        Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.user.store');
        Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.user.destroy');
    });

    // Mahasiswa Routes
    Route::middleware('role:mahasiswa,admin_master')->group(function () {
        Route::get('/mahasiswa/dashboard', [MahasiswaController::class, 'index'])->name('mahasiswa.dashboard');
        Route::post('/mahasiswa/magang', [MahasiswaController::class, 'storeMagang'])->name('mahasiswa.magang.store');
        Route::get('/mahasiswa/surat-balasan/{id}/download', [MahasiswaController::class, 'downloadSuratBalasan'])->name('mahasiswa.surat-balasan.download');
    });

    // Pegawai Routes
    Route::middleware('role:pegawai,admin_master')->group(function () {
        Route::get('/pegawai/dashboard', [PegawaiController::class, 'index'])->name('pegawai.dashboard');
        Route::post('/pegawai/peminjaman', [PegawaiController::class, 'storePeminjaman'])->name('pegawai.peminjaman.store');
    });
});