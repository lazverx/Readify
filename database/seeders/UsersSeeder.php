<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Pengguna;
use App\Models\Anggota;
use App\Models\HakAkses;

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
                'status' => 'active',
                'nomor_anggota' => null,
            ],
            [
                'name' => 'Faiz AP',
                'email' => 'admins@readify.id',
                'password' => 'admin123',
                'role' => 'admin',
                'level_akses' => 'admin',
                'status' => 'active',
                'nomor_anggota' => null,
            ],
            [
                'name' => 'Petugas Readify',
                'email' => 'petugas@readify.id',
                'password' => 'petugas123',
                'role' => 'petugas',
                'level_akses' => 'petugas',
                'status' => 'active',
                'nomor_anggota' => null,
            ],
            [
                'name' => 'Officer Readify',
                'email' => 'officer@readify.id',
                'password' => 'petugas123',
                'role' => 'petugas',
                'level_akses' => 'petugas',
                'status' => 'active',
                'nomor_anggota' => null,
            ],
            [
                'name' => 'Anggota Readify',
                'email' => 'anggota@readify.id',
                'password' => 'anggota123',
                'role' => 'pengguna',
                'level_akses' => 'anggota',
                'status' => 'active',
                'nomor_anggota' => 'ID-1-PX-2026',
            ],
            [
                'name' => 'Lazver',
                'email' => 'peritzzx@gmail.com',
                'password' => 'anggota123',
                'role' => 'pengguna',
                'level_akses' => 'anggota',
                'status' => 'active',
                'nomor_anggota' => 'ID-2-PX-2026',
            ],
        ];

        foreach ($users as $data) {
            // Cek atau buat user di tabel users Laravel
            $userRecord = DB::table('users')->where('email', $data['email'])->first();
            if (!$userRecord) {
                $userId = DB::table('users')->insertGetId([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'role' => $data['role'],
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $userId = $userRecord->id;
                DB::table('users')->where('id', $userId)->update([
                    'password' => Hash::make($data['password']),
                    'updated_at' => now(),
                ]);
            }

            // Cek atau buat di tabel pengguna Readify
            $pengguna = Pengguna::where('email', $data['email'])->first();
            if (!$pengguna) {
                $pengguna = Pengguna::create([
                    'id_pengguna' => $userId,
                    'nama_pengguna' => $data['name'],
                    'email' => $data['email'],
                    'kata_sandi' => Hash::make($data['password']),
                    'level_akses' => $data['level_akses'],
                    'status' => $data['status'],
                    'nomor_anggota' => $data['nomor_anggota'],
                ]);
            } else {
                $pengguna->update([
                    'nama_pengguna' => $data['name'],
                    'kata_sandi' => Hash::make($data['password']),
                    'level_akses' => $data['level_akses'],
                    'status' => $data['status'],
                    'nomor_anggota' => $data['nomor_anggota'] ?? $pengguna->nomor_anggota,
                ]);
            }

            // Jika role petugas, berikan semua hak akses default
            if ($data['level_akses'] === 'petugas') {
                $fiturList = ['kategori', 'buku', 'peminjaman', 'denda', 'laporan'];
                foreach ($fiturList as $fitur) {
                    HakAkses::firstOrCreate([
                        'id_pengguna' => $pengguna->id_pengguna,
                        'fitur' => $fitur,
                    ]);
                }
            }

            // Jika role anggota, pastikan profil anggota terbuat
            if ($data['level_akses'] === 'anggota') {
                Anggota::firstOrCreate(
                    ['id_pengguna' => $pengguna->id_pengguna],
                    [
                        'nama_lengkap' => $data['name'],
                        'alamat' => 'Jl. Pendidikan No. 12, Kota Pelajar',
                        'nomor_telepon' => '081234567890',
                    ]
                );
            }
        }

        $this->command->info('Users seeded successfully with complete permissions & active status.');
        $this->command->info('=== Login Credentials ===');
        $this->command->info('Admin   : admin@readify.id | admin123');
        $this->command->info('Petugas : petugas@readify.id | petugas123 (Full Rights: Buku, Kategori, Peminjaman, Denda, Laporan)');
        $this->command->info('Anggota : anggota@readify.id | anggota123 (Active Member, Card: ID-1-PX-2026)');
    }
}