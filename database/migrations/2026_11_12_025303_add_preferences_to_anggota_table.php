<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->json('preferensi_kategori')->nullable()->after('nomor_telepon');
            $table->unsignedInteger('target_baca_bulanan')->default(3)->after('preferensi_kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->dropColumn(['preferensi_kategori', 'target_baca_bulanan']);
        });
    }
};
