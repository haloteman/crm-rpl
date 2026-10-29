<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth', 'wajib-ganti-password', 'akses'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::post('/password', [PasswordController::class, 'update'])->name('password.update');

    Route::get('/dashboard', function () {
        // sementara 0 dulu, modul deal belum ada
        return view('dashboard', [
            'periode' => now()->translatedFormat('F Y'),
            'stats' => [
                'won_revenue' => 0,
                'lost_revenue' => 0,
                'deals_won' => 0,
                'deals_lost' => 0,
            ],
        ]);
    })->name('dashboard');
});
