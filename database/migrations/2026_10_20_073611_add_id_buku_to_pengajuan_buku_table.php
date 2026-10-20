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
        Schema::table('pengajuan_buku', function (Blueprint $table) {
            $table->unsignedBigInteger('id_buku')->nullable()->after('id_pengguna');
            $table->foreign('id_buku')->references('id_buku')->on('buku')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_buku', function (Blueprint $table) {
            $table->dropForeign(['id_buku']);
            $table->dropColumn('id_buku');
        });
    }
};
