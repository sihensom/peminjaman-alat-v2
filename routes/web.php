<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\DetailPeminjamanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// --- Root Redirect ---
Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// --- Dashboard (all authenticated users) ---
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// --- Authenticated routes (all roles) ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =============================================
// ADMIN-ONLY ROUTES
// =============================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    // CRUD User
    Route::resource('users', UserController::class)->except(['show']);

    // CRUD Kategori
    Route::resource('kategoris', KategoriController::class);

    // CRUD Alat (full)
    Route::resource('alats', AlatController::class);

    // CRUD Data Peminjaman
    Route::resource('peminjamans', PeminjamanController::class);

    // CRUD Pengembalian
    Route::resource('pengembalians', PengembalianController::class);

    // Log Aktifitas / Audit Sistem
    Route::get('/reports/audit', [\App\Http\Controllers\ReportController::class, 'audit'])->name('reports.audit');
});

// =============================================
// PETUGAS-ONLY ROUTES
// =============================================
Route::middleware(['auth', 'role:petugas'])->group(function () {
    // Menyetujui Peminjaman
    Route::get('/petugas/peminjamans', [PeminjamanController::class, 'index'])->name('petugas.peminjamans.index');
    Route::get('/petugas/peminjamans/{peminjaman}', [PeminjamanController::class, 'show'])->name('petugas.peminjamans.show');
    Route::post('peminjamans/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('peminjamans.approve');
    Route::post('peminjamans/{peminjaman}/reject', [PeminjamanController::class, 'reject'])->name('peminjamans.reject');

    // Memantau & Memproses Pengembalian
    Route::get('/petugas/pengembalians', [PengembalianController::class, 'index'])->name('petugas.pengembalians.index');
    Route::get('/petugas/pengembalians/create', [PengembalianController::class, 'create'])->name('petugas.pengembalians.create');
    Route::post('/petugas/pengembalians', [PengembalianController::class, 'store'])->name('petugas.pengembalians.store');
    Route::get('/petugas/pengembalians/{pengembalian}', [PengembalianController::class, 'show'])->name('petugas.pengembalians.show');

    // Mencetak Laporan
    Route::get('/reports/monthly', [\App\Http\Controllers\ReportController::class, 'monthly'])->name('reports.monthly');
    Route::get('/reports/monthly/print', [\App\Http\Controllers\ReportController::class, 'printMonthly'])->name('reports.print');
});

// =============================================
// PEMINJAM-ONLY ROUTES
// =============================================
Route::middleware(['auth', 'role:peminjam'])->group(function () {
    // Melihat daftar alat (read-only)
    Route::get('/peminjam/alats', [AlatController::class, 'index'])->name('peminjam.alats.index');
    Route::get('/peminjam/alats/{alat}', [AlatController::class, 'show'])->name('peminjam.alats.show');

    // Mengajukan peminjaman
    Route::get('/peminjam/peminjamans', [PeminjamanController::class, 'index'])->name('peminjam.peminjamans.index');
    Route::get('/peminjam/peminjamans/create', [PeminjamanController::class, 'create'])->name('peminjam.peminjamans.create');
    Route::post('/peminjam/peminjamans', [PeminjamanController::class, 'store'])->name('peminjam.peminjamans.store');
    Route::get('/peminjam/peminjamans/{peminjaman}', [PeminjamanController::class, 'show'])->name('peminjam.peminjamans.show');

    // Mengembalikan alat (mengajukan pengembalian)
    Route::get('/peminjam/pengembalians', [PengembalianController::class, 'index'])->name('peminjam.pengembalians.index');
    Route::get('/peminjam/pengembalians/{pengembalian}', [PengembalianController::class, 'show'])->name('peminjam.pengembalians.show');
});

require __DIR__.'/auth.php';
