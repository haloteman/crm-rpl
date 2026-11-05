<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// catatan interaksi dan follow-up bisa dibuat langsung dari profil pelanggan, tanpa lead
return new class extends Migration
{
    public function up(): void
    {
        foreach (['riwayat_interaksis', 'follow_ups'] as $namaTabel) {
            Schema::table($namaTabel, function (Blueprint $table) {
                $table->foreignId('lead_id')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        foreach (['riwayat_interaksis', 'follow_ups'] as $namaTabel) {
            Schema::table($namaTabel, function (Blueprint $table) {
                $table->foreignId('lead_id')->nullable(false)->change();
            });
        }
    }
};
