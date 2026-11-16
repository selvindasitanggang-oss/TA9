<?php

use Illuminate\Support\Facades\Route;
use Modules\Peminjaman\Http\Controllers\PeminjamanController;



Route::middleware('auth')->group(function () {
    Route::get('peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('peminjaman/data', [PeminjamanController::class, 'data'])->name('peminjaman.data');
    Route::get('peminjaman/{peminjaman}/bukti', [PeminjamanController::class, 'bukti'])->name('peminjaman.bukti');
    Route::post('peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::put('peminjaman/{peminjaman}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
    Route::delete('peminjaman/{peminjaman}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
});
