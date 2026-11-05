<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('instansi', 100)->nullable();
            $table->string('tipe_pemohon', 30);
            $table->string('no_hp', 20)->nullable();
            $table->string('no_hp_normal', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('email_normal')->nullable();
            $table->string('instagram', 100)->nullable();
            $table->string('sumber', 20);
            $table->string('status', 20)->default('Baru');
            $table->string('alasan_tidak_berlanjut')->nullable();
            $table->text('catatan_kebutuhan')->nullable();
            $table->text('catatan_kesepakatan')->nullable();
            $table->string('penanda', 30)->nullable();
            $table->boolean('is_baru')->default(true);
            $table->foreignId('penanggung_jawab_id')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('layanan_lead', function (Blueprint $table) {
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            $table->foreignId('layanan_id')->constrained('layanans');
            $table->primary(['lead_id', 'layanan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan_lead');
        Schema::dropIfExists('leads');
    }
};
