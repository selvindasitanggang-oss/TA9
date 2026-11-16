<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserManagementController;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard', [
            'stats' => [
                'books' => \Illuminate\Support\Facades\DB::table('buku')->count(),
                'stock' => \Illuminate\Support\Facades\DB::table('buku')->sum('stok'),
                'loans' => \Illuminate\Support\Facades\DB::table('peminjaman')->count(),
                'activeLoans' => \Illuminate\Support\Facades\DB::table('peminjaman')->where('status', 'Dipinjam')->count(),
            ],
        ]);
    })->name('dashboard');
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
        Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
