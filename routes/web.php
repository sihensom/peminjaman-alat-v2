<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\DetailPeminjamanController;
use Illuminate\Support\Facades\Route;

Route::get('/test-diag', function () {
    return [
        'ProfileController' => class_exists(\App\Http\Controllers\ProfileController::class),
        'AlatController' => class_exists(\App\Http\Controllers\AlatController::class),
        'KategoriController' => class_exists(\App\Http\Controllers\KategoriController::class),
        'PeminjamanController' => class_exists(\App\Http\Controllers\PeminjamanController::class),
        'PengembalianController' => class_exists(\App\Http\Controllers\PengembalianController::class),
        'DetailPeminjamanController' => class_exists(\App\Http\Controllers\DetailPeminjamanController::class),
    ];
});

Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/reports/monthly', [\App\Http\Controllers\ReportController::class, 'monthly'])->name('reports.monthly');
    Route::get('/reports/audit', [\App\Http\Controllers\ReportController::class, 'audit'])->name('reports.audit');
    Route::get('/reports/monthly/print', [\App\Http\Controllers\ReportController::class, 'printMonthly'])->name('reports.print');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('alats', AlatController::class);
    Route::resource('kategoris', KategoriController::class);
    
    Route::post('peminjamans/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('peminjamans.approve');
    Route::post('peminjamans/{peminjaman}/reject', [PeminjamanController::class, 'reject'])->name('peminjamans.reject');
    Route::resource('peminjamans', PeminjamanController::class);
    
    Route::resource('pengembalians', PengembalianController::class);
    Route::resource('detail-peminjamans', DetailPeminjamanController::class);
});

require __DIR__.'/auth.php';
