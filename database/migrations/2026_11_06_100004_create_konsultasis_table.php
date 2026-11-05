<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konsultasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads');
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('tempat', 150);
            $table->string('peserta')->nullable();
            $table->text('catatan')->nullable();
            $table->string('status', 20)->default('Dijadwalkan');
            $table->text('hasil')->nullable();
            $table->foreignId('dibuat_oleh')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konsultasis');
    }
};
