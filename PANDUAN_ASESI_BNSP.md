# CHEATSHEET & PANDUAN ASESI DEMONSTRASI BNSP
## SKEMA: PEMROGRAM JUNIOR (JUNIOR CODER) - FR.IA.02

Gunakan panduan ini saat menghadapi sesi tanya-jawab dan pembuktian unjuk kerja di depan Asesor Kompetensi.

---

### UNIT 1: Menggunakan Struktur Data (`J.620100.004.02`)
* **Pertanyaan Asesor**: *"Tunjukkan di mana struktur data diterapkan dalam aplikasi Anda!"*
* **Jawaban & Tunjukkan**:
  1. **Relasi Database & Foreign Key**: Tunjukkan model [Buku.php](file:///c:/xampp/htdocs/readify/app/Models/Buku.php), [Peminjaman.php](file:///c:/xampp/htdocs/readify/app/Models/Peminjaman.php), dan [Kategori.php](file:///c:/xampp/htdocs/readify/app/Models/Kategori.php).
     - Relasi *One-to-Many*: Satu Pengguna memiliki banyak Transaksi Peminjaman.
     - Relasi *Many-to-Many*: Satu Buku memiliki banyak Kategori melalui tabel pivot `buku_kategori`.
  2. **Tipe Data Kompleks**: Penggunaan tipe data `array`, `collection`, `casts` (seperti parsing tanggal dengan Carbon), dan JSON response.

---

### UNIT 2: Menggunakan Spesifikasi Program (`J.620100.009.01`)
* **Pertanyaan Asesor**: *"Apakah aplikasi sudah dibuat sesuai dengan gambar kerja ERD dan pembagian hak akses pada lembar soal?"*
* **Jawaban & Tunjukkan**:
  1. Tunjukkan file skema DDL [database/perpustakaan_bnsp_erd.sql](file:///c:/xampp/htdocs/readify/database/perpustakaan_bnsp_erd.sql) yang memuat ke-7 tabel sesuai gambar kerja (`user`, `buku`, `kategoribuku`, `kategoribuku_relasi`, `koleksipribadi`, `ulasanbuku`, `peminjaman`).
  2. Buka matriks hak akses di browser:
     - Admin: Kelola Buku, Kategori, Pengguna, Laporan, Hak Akses.
     - Petugas: Kelola Buku, Kategori, Validasi Peminjaman, Pengembalian, Laporan.
     - Peminjam: Registrasi mandiri, Pinjam/Booking buku, Ulasan & Rating.

---

### UNIT 3: Mengeksekusi Teks, Grafik, dan Multimedia (`J.620100.010.01`)
* **Pertanyaan Asesor**: *"Di mana fitur berbasis teks, grafik, dan multimedia diterapkan?"*
* **Jawaban & Tunjukkan**:
  1. **Multimedia/Gambar**: Fitur upload berkas gambar sampul buku ([BukuController.php:70](file:///c:/xampp/htdocs/readify/app/Http/Controllers/Admin/BukuController.php#L70)) dan avatar foto profil anggota.
  2. **Grafik/Visual**: Tampilan antarmuka Tailwind CSS yang responsif, badge status interaktif, dan kartu digital anggota.
  3. **Format Pelaporan**: Ekspor laporan cetak/PDF dan ekspor spreadsheet CSV/Excel pada menu Laporan ([LaporanController.php](file:///c:/xampp/htdocs/readify/app/Http/Controllers/Admin/LaporanController.php)).

---

### UNIT 4: Menulis Kode Sesuai Guidelines dan Best Practices (`J.620100.016.01`)
* **Pertanyaan Asesor**: *"Bagaimana Anda menjamin kode Anda aman dan sesuai best practices?"*
* **Jawaban & Tunjukkan**:
  1. Penerapan arsitektur **MVC (Model-View-Controller)** yang memisahkan data, logika bisnis, dan tampilan.
  2. Keamanan dari **SQL Injection** melalui PDO parameter binding di Eloquent ORM.
  3. Perlindungan terhadap serangan **CSRF (Cross-Site Request Forgery)** dengan `@csrf` token di setiap form.
  4. Enkripsi password menggunakan hashing **Bcrypt** (`Hash::make()`), bukan plaintext.
  5. Validasi form request yang ketat (`$request->validate()`).

---

### UNIT 5: Membuat Dokumen Kode Program (`J.620100.023.02`)
* **Pertanyaan Asesor**: *"Mana dokumen teknis kode program Anda?"*
* **Jawaban & Tunjukkan**:
  * Tunjukkan file [DOKUMEN_KODE_PROGRAM_BNSP.md](file:///c:/xampp/htdocs/readify/DOKUMEN_KODE_PROGRAM_BNSP.md) yang berisi spesifikasi sistem, kamus data lengkap, arsitektur, laporan pengujian, dan buku panduan pengoperasian.

---

### UNIT 6: Mengimplementasikan Pemrograman Terstruktur (`J.620100.017.02`)
* **Pertanyaan Asesor**: *"Bagaimana struktur alur program disusun?"*
* **Jawaban & Tunjukkan**:
  1. Pembagian controller modular berdasarkan perannya: `Admin\`, `Petugas\`, dan `Anggota\`.
  2. Logika bisnis terstruktur:
     - Algoritma generator kode booking unik: `Peminjaman::generateKodeBooking()`.
     - Algoritma kalkulasi denda: `Hari Terlambat * Rp 2.000`.
     - Logika perpanjangan peminjaman satu kali (2-3 hari).

---

### UNIT 7: Melakukan Debugging (`J.620100.025.02`)
* **Pertanyaan Asesor**: *"Bagaimana cara Anda melakukan penanganan error (debugging)?"*
* **Jawaban & Tunjukkan**:
  1. Penggunaan transaksi database `DB::beginTransaction()`, `DB::commit()`, dan `DB::rollBack()` di dalam blok `try - catch` untuk mencegah data korup jika terjadi kegagalan.
  2. Penanganan pesan kesalahan (*flash errors*) pada form input jika validasi gagal.
  3. Pengecekan file log sistem pada direktori `storage/logs/laravel.log`.

---

### UNIT 8 (Kelompok 2): Melaksanakan Pengujian Unit Program (`J.620100.033.02`)
* **Pertanyaan Asesor**: *"Jalankan pengujian unit program (Unit Testing) Anda!"*
* **Langkah Demonstrasi**:
  Buka terminal/PowerShell di folder proyek, lalu ketik perintah:
  ```bash
  php artisan test --testsuite=Unit
  ```
* **Hasil yang Ditunjukkan**:
  16 pengujian lulus (PASS) dengan 41 assertions tanpa error, mencakup:
  - Validasi formula denda keterlambatan
  - Pengecekan status jatuh tempo (`isTerlambat()`)
  - Validasi generator kode booking
  - Otorisasi hak akses role (Admin, Petugas, Anggota)
  - Formatting data buku (tahun, bahasa, sinopsis)
