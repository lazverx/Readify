<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create users with different roles (admin, petugas, anggota)
        $this->call(UsersSeeder::class);

        // Tambah 120 buku terkurasi dengan sampul, sinopsis, dan kategori lengkap
        $this->call(Buku120Seeder::class);

        // Buat data transaksi peminjaman & denda menggunakan buku nyata
        $this->call(DummyDataSeeder::class);
    }
}
