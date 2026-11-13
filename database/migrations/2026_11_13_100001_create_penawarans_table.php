<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penawarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads');
            $table->string('nomor_penawaran')->unique();
            $table->text('ruang_lingkup');
            $table->bigInteger('nilai_penawaran');
            $table->text('catatan_negosiasi')->nullable();
            $table->string('status', 20)->default('Draf');
            $table->bigInteger('harga_akhir')->nullable();
            $table->foreignId('harga_akhir_oleh')->nullable()->constrained('users');
            $table->timestamp('harga_akhir_at')->nullable();
            $table->string('alasan_lost')->nullable();
            $table->text('catatan_lost')->nullable();
            $table->foreignId('diputuskan_oleh')->nullable()->constrained('users');
            $table->timestamp('diputuskan_at')->nullable();
            $table->foreignId('dikirim_oleh')->nullable()->constrained('users');
            $table->timestamp('dikirim_at')->nullable();
            $table->foreignId('dibuat_oleh')->constrained('users');
            $table->foreignId('diubah_oleh')->nullable()->constrained('users');
            $table->timestamps();
        });

        Schema::create('penawaran_layanan', function (Blueprint $table) {
            $table->foreignId('penawaran_id')->constrained('penawarans')->cascadeOnDelete();
            $table->foreignId('layanan_id')->constrained('layanans');
            $table->primary(['penawaran_id', 'layanan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penawaran_layanan');
        Schema::dropIfExists('penawarans');
    }
};
