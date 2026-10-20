<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Tabel Postingan Komunitas
        Schema::create('postingan_komunitas', function (Blueprint $table) {
            $table->id('id_postingan');
            $table->unsignedBigInteger('id_pengguna');
            $table->unsignedBigInteger('id_buku')->nullable();
            $table->string('tipe', 30)->default('diskusi'); // diskusi, review, kutipan, rekomendasi
            $table->tinyInteger('rating')->nullable(); // 1 - 5 jika review
            $table->text('konten');
            $table->unsignedInteger('jumlah_like')->default(0);
            $table->unsignedInteger('jumlah_komentar')->default(0);
            $table->timestamp('dibuat_pada')->nullable();
            $table->timestamp('diperbarui_pada')->nullable();

            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
            $table->foreign('id_buku')->references('id_buku')->on('buku')->onDelete('set null');
        });

        // 2. Tabel Komentar Komunitas
        Schema::create('komentar_komunitas', function (Blueprint $table) {
            $table->id('id_komentar');
            $table->unsignedBigInteger('id_postingan');
            $table->unsignedBigInteger('id_pengguna');
            $table->text('konten');
            $table->timestamp('dibuat_pada')->nullable();
            $table->timestamp('diperbarui_pada')->nullable();

            $table->foreign('id_postingan')->references('id_postingan')->on('postingan_komunitas')->onDelete('cascade');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
        });

        // 3. Tabel Likes Postingan
        Schema::create('like_postingan', function (Blueprint $table) {
            $table->id('id_like');
            $table->unsignedBigInteger('id_postingan');
            $table->unsignedBigInteger('id_pengguna');
            $table->timestamp('dibuat_pada')->nullable();

            $table->unique(['id_postingan', 'id_pengguna']);
            $table->foreign('id_postingan')->references('id_postingan')->on('postingan_komunitas')->onDelete('cascade');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('like_postingan');
        Schema::dropIfExists('komentar_komunitas');
        Schema::dropIfExists('postingan_komunitas');
    }
};
