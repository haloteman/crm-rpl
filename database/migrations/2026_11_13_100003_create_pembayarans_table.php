<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kesepakatan_id')->constrained('kesepakatans');
            $table->date('tanggal_bayar');
            $table->bigInteger('jumlah');
            $table->string('metode', 20);
            $table->text('catatan')->nullable();
            $table->foreignId('dibuat_oleh')->constrained('users');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
