<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PemesananKendaraanController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\GrafikPemakaianController;
use App\Http\Controllers\BookingTanggalController;
use App\Http\Controllers\JadwalServiceController;

// Semua route ini hanya bisa diakses setelah login
Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return redirect()->route('pemesanan.grafik');
    });

    Route::get('/dashboard', [GrafikPemakaianController::class, 'index'])->name('dashboard');
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Hanya admin yang bisa akses ini
    Route::middleware(['Is_Admin'])->group(function () {
        Route::resource('pemesanan', PemesananKendaraanController::class);
        Route::resource('kendaraan', KendaraanController::class);
        Route::get('/export/pemesanan', [ExportController::class, 'exportPemesanan'])->name('export.pemesanan');
    });

    Route::get('/approval', [ApprovalController::class, 'index'])->name('approval.index');
    Route::post('/approval/{id}/approve', [ApprovalController::class, 'approve'])->name('approval.approve');

    Route::get('/grafik/pemakaian', [GrafikPemakaianController::class, 'index'])->name('pemesanan.grafik');
    Route::get('/booking/booked-dates', [BookingTanggalController::class, 'bookedDates'])->name('pemesanan.bookedDates');
    Route::get('/service/jadwal', [JadwalServiceController::class, 'index'])->name('service.index');

    Route::post('/approval/{id}/reject', [ApprovalController::class, 'reject'])->name('approval.reject');
    Route::put('/service/jadwal/{kendaraan}', [JadwalServiceController::class, 'update'])->name('service.update');
});

require __DIR__ . '/auth.php';
