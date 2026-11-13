<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\FormulirLayananController;
use App\Http\Controllers\KeputusanPenawaranController;
use App\Http\Controllers\KesepakatanController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\KonversiController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenawaranController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RiwayatInteraksiController;
use App\Http\Controllers\RoleController;
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

    Route::middleware('permission:kelola lead')->group(function () {
        Route::get('/leads', [LeadController::class, 'index'])->name('leads');
        Route::get('/leads/tambah', [LeadController::class, 'create'])->name('leads.create');
        Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');
        Route::get('/leads/{lead}', [LeadController::class, 'show'])->name('leads.show');
        Route::get('/leads/{lead}/ubah', [LeadController::class, 'edit'])->name('leads.edit');
        Route::post('/leads/{lead}/ubah', [LeadController::class, 'update'])->name('leads.update');
        Route::post('/leads/{lead}/hapus', [LeadController::class, 'destroy'])->name('leads.destroy');
        Route::post('/leads/{lead}/status', [LeadController::class, 'updateStatus'])->name('leads.status');
        Route::post('/leads/{lead}/penanggung-jawab', [LeadController::class, 'tetapkanPenanggungJawab'])->name('leads.penanggung-jawab');
        Route::post('/leads/{lead}/ambil', [LeadController::class, 'ambil'])->name('leads.ambil');
        Route::post('/leads/{lead}/interaksi', [RiwayatInteraksiController::class, 'store'])->name('interaksi.store');
        Route::post('/leads/{lead}/follow-up', [FollowUpController::class, 'store'])->name('follow-up.store');
        Route::post('/leads/{lead}/konsultasi', [KonsultasiController::class, 'store'])->name('konsultasi.store');
        Route::post('/konsultasi/{konsultasi}/hasil', [KonsultasiController::class, 'updateHasil'])->name('konsultasi.hasil');
        Route::post('/leads/{lead}/deal', [DealController::class, 'tetapkan'])->name('leads.deal');
        Route::post('/leads/{lead}/konversi', [KonversiController::class, 'konversi'])->name('leads.konversi');
        Route::get('/customer', [PelangganController::class, 'index'])->name('customer');
        Route::get('/customer/{pelanggan}', [PelangganController::class, 'show'])->name('customer.show');
        Route::get('/customer/{pelanggan}/ubah', [PelangganController::class, 'edit'])->name('customer.edit');
        Route::post('/customer/{pelanggan}/ubah', [PelangganController::class, 'update'])->name('customer.update');
        Route::post('/customer/{pelanggan}/interaksi', [RiwayatInteraksiController::class, 'storePelanggan'])->name('customer.interaksi');
        Route::post('/customer/{pelanggan}/follow-up', [FollowUpController::class, 'storePelanggan'])->name('customer.follow-up');
        Route::post('/follow-up/{followUp}/selesai', [FollowUpController::class, 'selesai'])->name('follow-up.selesai');
    });

    Route::middleware('permission:kelola penawaran')->group(function () {
        Route::get('/penawaran', [PenawaranController::class, 'index'])->name('penawaran');
        Route::get('/penawaran/tambah', [PenawaranController::class, 'create'])->name('penawaran.create');
        Route::post('/penawaran', [PenawaranController::class, 'store'])->name('penawaran.store');
        Route::get('/penawaran/{penawaran}', [PenawaranController::class, 'show'])->name('penawaran.show');
        Route::get('/penawaran/{penawaran}/ubah', [PenawaranController::class, 'edit'])->name('penawaran.edit');
        Route::post('/penawaran/{penawaran}/ubah', [PenawaranController::class, 'update'])->name('penawaran.update');
        Route::post('/penawaran/{penawaran}/kirim', [PenawaranController::class, 'kirim'])->name('penawaran.kirim');
        Route::post('/penawaran/{penawaran}/harga-akhir', [KeputusanPenawaranController::class, 'hargaAkhir'])->name('penawaran.harga-akhir');
        Route::post('/penawaran/{penawaran}/won', [KeputusanPenawaranController::class, 'won'])->name('penawaran.won');
        Route::post('/penawaran/{penawaran}/lost', [KeputusanPenawaranController::class, 'lost'])->name('penawaran.lost');
        Route::post('/penawaran/{penawaran}/kesepakatan', [KesepakatanController::class, 'store'])->name('kesepakatan.store');
        Route::post('/kesepakatan/{kesepakatan}/ubah', [KesepakatanController::class, 'update'])->name('kesepakatan.update');
    });

    Route::middleware('permission:kelola akun')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset');
        Route::post('/users/{user}/hapus', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    });
});
