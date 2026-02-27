<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Buku;
use App\Models\Pengguna;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Denda;
use App\Models\Anggota;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Faker\Factory as Faker;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // =========================
        // 1. KATEGORI
        // =========================
        $kategoriNames = ['Fiksi', 'Sains', 'Sejarah', 'Teknologi', 'Seni', 'Biografi', 'Bisnis', 'Anak-anak'];

        foreach ($kategoriNames as $name) {
            Kategori::updateOrCreate(['nama_kategori' => $name]);
        }

        $kategoriIds = Kategori::pluck('id_kategori')->toArray();

        // =========================
        // 2. BUKU
        // =========================
        $bukuData = [
            ['judul_buku' => 'Laskar Pelangi', 'penulis' => 'Andrea Hirata', 'stok' => 10],
            ['judul_buku' => 'Bumi', 'penulis' => 'Tere Liye', 'stok' => 5],
            ['judul_buku' => 'Sapiens', 'penulis' => 'Yuval Noah Harari', 'stok' => 3],
            ['judul_buku' => 'Clean Code', 'penulis' => 'Robert C. Martin', 'stok' => 7],
            ['judul_buku' => 'Atomic Habits', 'penulis' => 'James Clear', 'stok' => 12],
        ];

        foreach ($bukuData as $data) {
            Buku::updateOrCreate(
                ['judul_buku' => $data['judul_buku']],
                [
                    'isbn' => $faker->isbn13(),
                    'penulis' => $data['penulis'],
                    'penerbit' => $faker->company(),
                    'stok' => $data['stok'],
                    'id_kategori' => $kategoriIds[array_rand($kategoriIds)],
                    'lokasi_rak' => 'Rak ' . strtoupper($faker->randomLetter()) . '-' . rand(1, 20),
                ]
            );
        }

        $bukuIds = Buku::pluck('id_buku')->toArray();

        // =========================
        // 3. ANGGOTA (USER LEVEL ANGGOTA)
        // =========================
        for ($i = 1; $i <= 15; $i++) {

            $email = $faker->unique()->safeEmail();

            $pengguna = Pengguna::create([
                'nama_pengguna' => $faker->userName(),
                'email' => $email,
                'kata_sandi' => Hash::make('password'),
                'level_akses' => 'anggota',
            ]);

            Anggota::create([
                'id_pengguna' => $pengguna->id_pengguna,
                'nama_lengkap' => $faker->name(),
                'alamat' => $faker->address(),
                'nomor_telepon' => $faker->numerify('08##########'),
            ]);
        }

        $anggotaIds = Pengguna::where('level_akses', 'anggota')
            ->pluck('id_pengguna')
            ->toArray();

        // =========================
        // 4. PEMINJAMAN
        // =========================
        $statuses = ['dipinjam', 'dikembalikan', 'terlambat'];

        for ($i = 1; $i <= 20; $i++) {

            $tglPinjam = Carbon::now()->subDays(rand(1, 30));
            $deadline = $tglPinjam->copy()->addDays(7);
            $status = $statuses[array_rand($statuses)];

            $idPengguna = $anggotaIds[array_rand($anggotaIds)];
            $randomBukuId = $bukuIds[array_rand($bukuIds)];

            $peminjaman = Peminjaman::create([
                'id_pengguna' => $idPengguna,
                'id_buku' => $randomBukuId,
                'tgl_pinjam' => $tglPinjam,
                'tgl_kembali' => $deadline, // deadline
                'status_transaksi' => $status,
            ]);

            DetailPeminjaman::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'id_buku' => $randomBukuId,
                'jumlah' => 1,
            ]);

            // =========================
            // 5. DENDA (HANYA JIKA TERLAMBAT)
            // =========================
            if ($status === 'terlambat') {

                $hariTerlambat = Carbon::now()->diffInDays($deadline);
                $jumlahDenda = max(1, $hariTerlambat) * 1000;

                Denda::create([
                    'id_peminjaman' => $peminjaman->id_peminjaman,
                    'jumlah_denda' => $jumlahDenda,
                    'status_pembayaran' => rand(0, 1) ? 'lunas' : 'belum_bayar',
                ]);
            }
        }

        $this->command->info('Dummy data for Readify successfully seeded.');
    }
}