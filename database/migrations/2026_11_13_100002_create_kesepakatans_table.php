<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kesepakatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penawaran_id')->unique()->constrained('penawarans');
            $table->bigInteger('nilai_kesepakatan');
            $table->text('ketentuan_pekerjaan');
            $table->date('tanggal_kesepakatan');
            $table->date('masa_kontrak_mulai')->nullable();
            $table->date('masa_kontrak_selesai')->nullable();
            $table->string('frekuensi_update_progres', 100)->nullable();
            $table->string('status_pembayaran', 20)->default('Belum Dibayar');
            $table->foreignId('dibuat_oleh')->constrained('users');
            $table->foreignId('diubah_oleh')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kesepakatans');
    }
};
