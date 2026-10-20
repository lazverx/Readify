<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Buku;
use App\Models\Kategori;

class Buku120Seeder extends Seeder
{
    public function run(): void
    {
        $books = require __DIR__ . '/data_buku_120.php';
        $totalBooks = count($books);

        $this->command->info("Memulai seeding {$totalBooks} buku baru (54 Manga & 66 Novel English)...");

        // 1. Pastikan Kategori-kategori Utama Terdaftar
        $allCategoryNames = ['Manga', 'Novel', 'Fiksi', 'Sains', 'Sejarah', 'Teknologi', 'Seni', 'Biografi', 'Bisnis', 'Filosofi'];
        $categoriesMap = [];
        foreach ($allCategoryNames as $catName) {
            $cat = Kategori::firstOrCreate(['nama_kategori' => $catName]);
            $categoriesMap[$catName] = $cat->id_kategori;
        }

        // Direktori penyimpanan sampul
        $targetDir = storage_path('app/public/sampul');
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // Cari file fallback yang sudah ada
        $existingFiles = glob($targetDir . '/*.{jpg,jpeg,png}', GLOB_BRACE);
        $sampleFallback = !empty($existingFiles) ? $existingFiles[0] : null;

        $downloadSuccess = 0;
        $fallbackCount = 0;

        foreach ($books as $index => $item) {
            $num = $index + 1;
            $slug = Str::slug($item['judul_buku']);
            $filename = $slug . '.jpg';
            $filePath = $targetDir . DIRECTORY_SEPARATOR . $filename;
            $dbSampulPath = 'sampul/' . $filename;

            // Jika file belum ada di storage, download cover
            if (!file_exists($filePath)) {
                $downloaded = false;

                if (!empty($item['cover_url'])) {
                    $ch = curl_init($item['cover_url']);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 4);
                    curl_setopt($ch, CURLOPT_USERAGENT, 'ReadifyLibrary/1.0');
                    $imageData = curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);

                    // OpenLibrary returns a 1x1 gif/jpg or < 1000 bytes on 404
                    if ($httpCode === 200 && strlen($imageData) > 1500) {
                        file_put_contents($filePath, $imageData);
                        $downloaded = true;
                        $downloadSuccess++;
                    }
                }

                // Jika download gagal/timeout, gunakan sample fallback agar gambar tetap tampil
                if (!$downloaded && $sampleFallback && file_exists($sampleFallback)) {
                    copy($sampleFallback, $filePath);
                    $fallbackCount++;
                }
            } else {
                $downloadSuccess++;
            }

            // Simpan atau update buku di database
            $buku = Buku::updateOrCreate(
                ['judul_buku' => $item['judul_buku']],
                [
                    'isbn' => $item['isbn'],
                    'penulis' => $item['penulis'],
                    'penerbit' => $item['penerbit'],
                    'tahun_terbit' => $item['tahun_terbit'],
                    'stok' => $item['stok'],
                    'jumlah_halaman' => $item['jumlah_halaman'],
                    'bahasa' => $item['bahasa'],
                    'sampul' => $dbSampulPath,
                    'lokasi_rak' => $item['lokasi_rak'],
                    'sinopsis' => $item['sinopsis'],
                ]
            );

            // Hubungkan relasi kategori
            $catIds = [];
            foreach ($item['kategori'] as $cName) {
                if (isset($categoriesMap[$cName])) {
                    $catIds[] = $categoriesMap[$cName];
                }
            }
            if (!empty($catIds)) {
                $buku->kategori()->sync($catIds);
            }

            if ($num % 20 === 0 || $num === $totalBooks) {
                $this->command->info("Progres: {$num} / {$totalBooks} buku berhasil diproses.");
            }
        }

        $this->command->info("=== SEEDING SELESAI ===");
        $this->command->info("Total Buku Diproses : {$totalBooks}");
        $this->command->info("Cover Downloaded    : {$downloadSuccess}");
        $this->command->info("Cover Fallback      : {$fallbackCount}");
        $this->command->info("Database sekarang memiliki: " . Buku::count() . " buku.");
    }
}
