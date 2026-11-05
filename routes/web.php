<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormulirLayananController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// website company profile, bisa dibuka tanpa login
Route::view('/', 'website.beranda')->name('website.beranda');
Route::view('/tentang-kami', 'website.tentang-kami')->name('website.tentang-kami');
Route::view('/layanan', 'website.layanan')->name('website.layanan');
Route::view('/portofolio', 'website.portofolio')->name('website.portofolio');
Route::view('/kontak', 'website.kontak')->name('website.kontak');
Route::get('/permintaan-layanan', [FormulirLayananController::class, 'create'])->name('website.formulir');
Route::post('/permintaan-layanan', [FormulirLayananController::class, 'submit']);
Route::view('/permintaan-layanan/terkirim', 'website.konfirmasi')->name('website.konfirmasi');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth', 'wajib-ganti-password'])->group(function () {
    Route::get('/crm', function () {
        return redirect()->route(auth()->user()->halamanBeranda());
    })->name('beranda');

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
    })->name('dashboard')->middleware('permission:lihat dashboard');

    Route::middleware('permission:kelola akun')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset');
        Route::post('/users/{user}/hapus', [UserController::class, 'destroy'])->name('users.destroy');
    });
});
