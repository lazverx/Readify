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

        // Create dummy data for books, categories, etc.
        $this->call(DummyDataSeeder::class);

        // Tambah 120 buku baru (54 manga & 66 novel english)
        $this->call(Buku120Seeder::class);
    }
}
