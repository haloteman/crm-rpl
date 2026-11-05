<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_interaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads');
            $table->dateTime('waktu');
            $table->string('jenis', 30);
            $table->string('kanal', 20)->nullable();
            $table->text('ringkasan');
            $table->string('status_lama', 20)->nullable();
            $table->string('status_baru', 20)->nullable();
            $table->foreignId('dibuat_oleh')->constrained('users');
            $table->timestamps();
        });

        Schema::create('follow_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads');
            $table->date('tanggal');
            $table->string('jenis', 20);
            $table->text('catatan_tujuan')->nullable();
            $table->boolean('selesai')->default(false);
            $table->dateTime('selesai_pada')->nullable();
            $table->foreignId('dibuat_oleh')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('follow_ups');
        Schema::dropIfExists('riwayat_interaksis');
    }
};
