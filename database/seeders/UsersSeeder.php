<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Pengguna;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Readify',
                'email' => 'admin@readify.id',
                'password' => 'admin123',
                'role' => 'admin',
                'level_akses' => 'admin',
            ],
            [
                'name' => 'Petugas Readify',
                'email' => 'petugas@readify.id',
                'password' => 'petugas123',
                'role' => 'petugas',
                'level_akses' => 'petugas',
            ],
            [
                'name' => 'Anggota Readify',
                'email' => 'anggota@readify.id',
                'password' => 'anggota123',
                'role' => 'anggota',
                'level_akses' => 'anggota',
            ],
        ];

        foreach ($users as $data) {

            $userId = DB::table('users')->insertGetId([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Pengguna::create([
                'id_pengguna' => $userId,
                'nama_pengguna' => $data['name'],
                'email' => $data['email'],
                'kata_sandi' => Hash::make($data['password']),
                'level_akses' => $data['level_akses'],
            ]);
        }

        $this->command->info('Users seeded successfully.');
        $this->command->info('Login Credentials:');
        $this->command->info('Admin   : admin@readify.id | admin123');
        $this->command->info('Petugas : petugas@readify.id | petugas123');
        $this->command->info('Anggota : anggota@readify.id | anggota123');
    }
}