<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id('id_log');
            $table->unsignedBigInteger('id_pengguna')->nullable();
            $table->string('nama_pengguna')->nullable();
            $table->string('role', 50)->default('anggota');
            $table->string('aksi', 100);
            $table->text('deskripsi');
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();

            $table->foreign('id_pengguna')
                ->references('id_pengguna')
                ->on('pengguna')
                ->onDelete('set null');

            $table->index(['aksi', 'dibuat_pada']);
            $table->index('id_pengguna');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
    }
};
