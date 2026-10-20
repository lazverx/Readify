<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah enum tipe menjadi string agar fleksibel untuk jenis notifikasi baru
        DB::statement("ALTER TABLE notifikasi MODIFY COLUMN tipe VARCHAR(50) NOT NULL");

        Schema::table('notifikasi', function (Blueprint $table) {
            if (!Schema::hasColumn('notifikasi', 'id_peminjaman')) {
                $table->unsignedBigInteger('id_peminjaman')->nullable()->after('id_pengajuan');
                $table->string('link')->nullable()->after('pesan');

                $table->foreign('id_peminjaman')
                    ->references('id_peminjaman')
                    ->on('peminjaman')
                    ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('notifikasi', function (Blueprint $table) {
            if (Schema::hasColumn('notifikasi', 'id_peminjaman')) {
                $table->dropForeign(['id_peminjaman']);
                $table->dropColumn(['id_peminjaman', 'link']);
            }
        });
    }
};
