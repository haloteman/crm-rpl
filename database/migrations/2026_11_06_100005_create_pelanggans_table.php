<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('instansi', 100)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('no_hp_normal', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('email_normal')->nullable();
            $table->string('instagram', 100)->nullable();
            $table->string('sumber_awal', 20);
            $table->text('catatan')->nullable();
            $table->date('tanggal_menjadi_pelanggan');
            $table->timestamps();
        });

        foreach (['leads', 'riwayat_interaksis', 'follow_ups', 'konsultasis'] as $namaTabel) {
            Schema::table($namaTabel, function (Blueprint $table) {
                $table->foreignId('pelanggan_id')->nullable()->after('id')->constrained('pelanggans');
            });
        }
    }

    public function down(): void
    {
        foreach (['leads', 'riwayat_interaksis', 'follow_ups', 'konsultasis'] as $namaTabel) {
            Schema::table($namaTabel, function (Blueprint $table) {
                $table->dropConstrainedForeignId('pelanggan_id');
            });
        }

        Schema::dropIfExists('pelanggans');
    }
};
