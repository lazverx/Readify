# DOKUMEN KODE PROGRAM & SPESIFIKASI SISTEM
## APLIKASI PERPUSTAKAAN DIGITAL (READIFY)

**Skema Sertifikasi** : Pemrogram Junior (Junior Coder)  
**Kode Skema** : KKNI Level II Rekayasa Perangkat Lunak  
**Instrumen Asesmen** : FR.IA.02. TPD - Tugas Praktik Demonstrasi  
**Unit Kompetensi** : J.620100.023.02 (Membuat Dokumen Kode Program)  
**Tahun** : 2026  

---

## 1. PENDAHULUAN & RUANG LINGKUP SISTEM

### 1.1 Deskripsi Aplikasi
Aplikasi **Readify** adalah perangkat lunak sistem informasi **Perpustakaan Digital** berbasis web *client-server*. Aplikasi ini dirancang untuk memfasilitasi operasional sirkulasi peminjaman dan pengembalian buku, manajemen katalog pustaka, pelacakan keterlambatan dan denda, pencatatan ulasan (*review* & *rating*), serta penyusunan laporan periodik yang komunikatif bagi pengelola perpustakaan.

### 1.2 Tujuan Pembuatan Program
1. Mengotomatisasi proses pendataan buku, kategori, dan keanggotaan.
2. Memberikan kemudahan bagi peminjam (siswa/masyarakat) untuk mencari katalog buku, meminjam/booking buku secara mandiri, mengelola wishlist (koleksi pribadi), dan memberikan rating/ulasan.
3. Menerapkan pembagian hak akses (*multi-level privilege*) secara aman dan terstruktur antara **Administrator**, **Petugas**, dan **Peminjam**.
4. Menyediakan sistem denda otomatis saat terjadi keterlambatan pengembalian buku.
5. Menghasilkan laporan sirkulasi yang informatif dan dapat diekspor ke format cetak (PDF) maupun Excel (CSV).

---

## 2. SPESIFIKASI LINGKUNGAN PENGEMBANGAN & PERANGKAT KERJA

### 2.1 Perangkat Keras (Hardware)
* Processor: Intel Core i3/i5/i7 / AMD Ryzen setara (x64 architecture)
* RAM: Minimal 4 GB (Direkomendasikan 8 GB ke atas)
* Harddisk / SSD: Tersedia minimal ruang kosong 2 GB
* Monitor, Keyboard, dan Mouse

### 2.2 Perangkat Lunak (Software Stack)
* **Sistem Operasi**: Windows 10/11 64-bit
* **Web Server**: Apache / PHP Development Server
* **Database Management System (DBMS)**: MySQL / MariaDB (XAMPP v3.3+)
* **Bahasa Pemrograman**: PHP Version 8.2+
* **Framework Backend**: Laravel 11 (Arsitektur Model-View-Controller)
* **Frontend Styling & UI/UX**: Tailwind CSS 4, Alpine.js, Blade Templating Engine
* **Source Code Editor**: Visual Studio Code / Cursor / PHPStorm
* **Target Eksekusi**: Browser (Google Chrome, Microsoft Edge, Mozilla Firefox)

---

## 3. ARSITEKTUR PERANGKAT LUNAK (SOFTWARE ARCHITECTURE)

Readify dibangun menggunakan prinsip **Pemrograman Berorientasi Objek (Object Oriented Programming - OOP)** dengan pola arsitektur **Model-View-Controller (MVC)**:

```
                  ┌─────────────────────────────────────────┐
                  │                 BROWSER                 │
                  │              (Client-Side)              │
                  └────────────────────┬────────────────────┘
                                       │ HTTP Request
                                       ▼
                  ┌─────────────────────────────────────────┐
                  │              routes/web.php             │
                  └────────────────────┬────────────────────┘
                                       │
                         [ Middleware Otorisasi & Auth ]
                                       │
                                       ▼
                  ┌─────────────────────────────────────────┐
                  │               CONTROLLERS               │
                  │  - AuthController                       │
                  │  - Admin\ (Buku, Kategori, Denda, dll)  │
                  │  - Petugas\ (PetugasController)         │
                  │  - Anggota\ (AnggotaController, Ulasan) │
                  └──────────────┬──────────────────┬───────┘
                                 │                  │
                Eloquent ORM / DB│                  │ Render View
                                 ▼                  ▼
                  ┌────────────────────┐   ┌────────────────────────┐
                  │       MODELS       │   │      VIEWS (BLADE)     │
                  │  - Pengguna        │   │  - layouts/app         │
                  │  - Buku            │   │  - admin/              │
                  │  - Kategori        │   │  - petugas/            │
                  │  - Peminjaman      │   │  - anggota/            │
                  │  - Denda           │   │  - auth/               │
                  │  - Ulasan          │   └────────────────────────┘
                  │  - KoleksiPribadi  │
                  └──────────────┬─────┘
                                 │
                                 ▼
                  ┌─────────────────────────────────────────┐
                  │            DATABASE (MySQL)             │
                  └─────────────────────────────────────────┘
```

---

## 4. SPESIFIKASI BASIS DATA & KAMUS DATA (ERD)

Sesuai dengan **Gambar Kerja FR.IA.02 Halaman 2**, database mencakup 7 tabel relasional utama:

### 4.1 Tabel `user` / `pengguna`
Menyimpan identitas autentikasi dan profil pengguna aplikasi.
| Nama Kolom | Tipe Data | Kunci | Keterangan |
| :--- | :--- | :---: | :--- |
| `UserID` (`id_pengguna`) | INT(11) | **PK** | Primary Key (Auto Increment) |
| `Username` (`nama_pengguna`)| VARCHAR(255) | Unique | Nama akun untuk login |
| `Password` (`kata_sandi`) | VARCHAR(255) | - | Sandi terenkripsi Bcrypt |
| `Email` | VARCHAR(255) | Unique | Alamat surat elektronik aktif |
| `NamaLengkap` | VARCHAR(255) | - | Nama lengkap pengguna (Tabel anggota) |
| `Alamat` | TEXT | - | Alamat tempat tinggal |
| `Role` (`level_akses`) | ENUM | - | administrator, petugas, anggota/peminjam |
| `status` | ENUM | - | pending, active, rejected |
| `nomor_anggota` | VARCHAR(50) | Unique | Nomor ID kartu anggota perpustakaan |

### 4.2 Tabel `buku`
Menyimpan seluruh katalog buku perpustakaan.
| Nama Kolom | Tipe Data | Kunci | Keterangan |
| :--- | :--- | :---: | :--- |
| `BukuID` (`id_buku`) | INT(11) | **PK** | Primary Key (Auto Increment) |
| `Judul` (`judul_buku`) | VARCHAR(255) | - | Judul pustaka |
| `Penulis` | VARCHAR(255) | - | Nama pengarang/penulis |
| `Penerbit` | VARCHAR(255) | - | Nama penerbit buku |
| `TahunTerbit` (`tahun_terbit`) | INT(11) | - | Tahun cetak/terbit buku |
| `stok` | INT(11) | - | Ketersediaan eksemplar buku |
| `sampul` | VARCHAR(255) | - | Path file berkas cover gambar |
| `lokasi_rak` | VARCHAR(50) | - | Penempatan rak buku |

### 4.3 Tabel `kategoribuku` / `kategori`
Menyimpan klasifikasi tema/genre buku.
| Nama Kolom | Tipe Data | Kunci | Keterangan |
| :--- | :--- | :---: | :--- |
| `KategoriID` (`id_kategori`) | INT(11) | **PK** | Primary Key (Auto Increment) |
| `NamaKategori` (`nama_kategori`) | VARCHAR(255) | - | Nama kategori (Fiksi, Sains, dll.) |

### 4.4 Tabel `kategoribuku_relasi` / `buku_kategori`
Tabel perantara relasi *Many-to-Many* antara buku dan kategori.
| Nama Kolom | Tipe Data | Kunci | Keterangan |
| :--- | :--- | :---: | :--- |
| `KategoriBukuID` (`id`) | INT(11) | **PK** | Primary Key (Auto Increment) |
| `BukuID` (`id_buku`) | INT(11) | **FK** | Foreign Key ke tabel `buku` |
| `KategoriID` (`id_kategori`) | INT(11) | **FK** | Foreign Key ke tabel `kategori` |

### 4.5 Tabel `peminjaman`
Menyimpan histori dan transaksi peminjaman buku oleh peminjam.
| Nama Kolom | Tipe Data | Kunci | Keterangan |
| :--- | :--- | :---: | :--- |
| `PeminjamanID` (`id_peminjaman`) | INT(11) | **PK** | Primary Key (Auto Increment) |
| `UserID` (`id_pengguna`) | INT(11) | **FK** | Foreign Key ke tabel `user` |
| `BukuID` (`id_buku`) | INT(11) | **FK** | Foreign Key ke tabel `buku` |
| `kode_booking` | VARCHAR(50) | Unique | Kode unik pengambilan buku |
| `TanggalPeminjaman` (`tgl_pinjam`) | DATE | - | Tanggal buku diambil |
| `TanggalPengembalian` (`tgl_kembali`) | DATE | - | Tanggal pengembalian / jatuh tempo |
| `StatusPeminjaman` (`status_transaksi`) | VARCHAR(50) | - | booking, dipinjam, terlambat, dikembalikan |

### 4.6 Tabel `denda`
Menyimpan tagihan penalti keterlambatan sirkulasi buku.
| Nama Kolom | Tipe Data | Kunci | Keterangan |
| :--- | :--- | :---: | :--- |
| `id_denda` | INT(11) | **PK** | Primary Key (Auto Increment) |
| `id_peminjaman` | INT(11) | **FK** | Foreign Key ke tabel `peminjaman` |
| `jumlah_denda` | DECIMAL(10,2)| - | Nominal denda (Rp 2.000 / hari terlambat) |
| `status_pembayaran` | ENUM | - | `belum_bayar` atau `lunas` |

### 4.7 Tabel `koleksipribadi`
Menyimpan daftar bacaan favorit/wishlist anggota.
| Nama Kolom | Tipe Data | Kunci | Keterangan |
| :--- | :--- | :---: | :--- |
| `KoleksiID` (`id_koleksi`) | INT(11) | **PK** | Primary Key (Auto Increment) |
| `UserID` (`id_pengguna`) | INT(11) | **FK** | Foreign Key ke tabel `user` |
| `BukuID` (`id_buku`) | INT(11) | **FK** | Foreign Key ke tabel `buku` |

### 4.8 Tabel `ulasanbuku` / `ulasan`
Menyimpan ulasan tekstual dan penilaian bintang dari pembaca.
| Nama Kolom | Tipe Data | Kunci | Keterangan |
| :--- | :--- | :---: | :--- |
| `UlasanID` (`id_ulasan`) | INT(11) | **PK** | Primary Key (Auto Increment) |
| `UserID` (`id_pengguna`) | INT(11) | **FK** | Foreign Key ke tabel `user` |
| `BukuID` (`id_buku`) | INT(11) | **FK** | Foreign Key ke tabel `buku` |
| `Ulasan` (`isi_ulasan`) | TEXT | - | Testimoni/ulasan pembaca |
| `Rating` | INT(11) | - | Rating skala 1 s.d. 5 |

---

## 5. MATRIKS HAK AKSES & PRIVILEGE OTORISASI (HALAMAN 3)

Sesuai ketentuan FR.IA.02 Halaman 3, sistem menerapkan pembagian hak akses:

| Fitur / Modul | Administrator | Petugas | Peminjam | Implementasi Kode |
| :--- | :---: | :---: | :---: | :--- |
| **Login** | ✓ | ✓ | ✓ | `AuthController@showLoginForm`, `AuthController@login` |
| **Logout** | ✓ | ✓ | ✓ | `AuthController@logout` |
| **Registrasi** | ✓ | - | ✓ | Registrasi mandiri di `/register`, Admin kelola akun di `/pengguna` |
| **Pendataan Barang (Buku/Kategori)** | ✓ | ✓ | - | Route `/buku`, `/kategori` dilindungi middleware `akses:buku` & `akses:kategori` |
| **Peminjaman** | - | - | ✓ | Peminjam booking online; Petugas memvalidasi kode booking & pengembalian |
| **Kelola Denda** | ✓ | ✓ | - | Route `/denda` (hitung denda otomatis, pelunasan di meja petugas/admin) |
| **Generate Laporan** | ✓ | ✓ | - | Route `/laporan` dengan ekspor cetak PDF dan ekspor Excel |

---

## 6. PENJELASAN MODUL & LOGIKA PROGRAM

### 6.1 Autentikasi & Verifikasi Akun (`AuthController.php`)
- Peminjam mendaftar mandiri via form registrasi. Password di-*hash* menggunakan algoritma `Bcrypt`.
- Mendukung verifikasi anggota oleh Administrator: anggota baru mendapatkan status `active` dan *Member Card Number* unik berformat `ID-{Nomor}-PX-{Tahun}`.

### 6.2 Siklus Transaksi Peminjaman & Denda
1. **Pemesanan Mandiri (Booking Online)**: Peminjam memilih buku di katalog anggota dan menentukan durasi. Sistem menghasilkan **Kode Booking Unik** (misal: `BK261020ABCD`). Stok buku dipesan.
2. **Serah Terima Pustaka**: Peminjam menunjukkan kode booking ke meja petugas sirkulasi. Petugas menginput kode booking, status berubah menjadi **Dipinjam** dan tanggal pinjam aktual dicatat.
3. **Pengembalian Buku & Kalkulasi Denda**:
   - Jika dikembalikan sebelum deadline: status peminjaman menjadi `dikembalikan`, stok buku di-*restore* (+1).
   - Jika melewati jatuh tempo: sistem otomatis mendeteksi keterlambatan, menghitung jumlah hari terlambat, dan menghitung penalti:
     $$\text{Denda} = \text{Hari Terlambat} \times \text{Rp } 2.000$$
   - Denda tercatat dengan status `belum_bayar`. Petugas atau Administrator dapat menandai `lunas` langsung saat anggota membayar.

---

## 7. LAPORAN PENGUJIAN UNIT PROGRAM (UNIT TESTING - KELOMPOK PEKERJAAN 2)

Pengujian unit dilakukan menggunakan **PHPUnit** pada lingkungan Laravel Testing untuk memvalidasi algoritma bisnis tanpa tergantung pada antarmuka web:

* **File Test Suite**:
  1. `tests/Unit/PeminjamanTest.php`
  2. `tests/Unit/BukuTest.php`
  3. `tests/Unit/PenggunaTest.php`
  4. `tests/Unit/ExampleTest.php`

### Hasil Eksekusi Test:
```bash
php artisan test --testsuite=Unit
```
```
   PASS  Tests\Unit\BukuTest
  ✓ formatted tahun terbit
  ✓ formatted jumlah halaman
  ✓ sinopsis preview truncation
  ✓ formatted bahasa

   PASS  Tests\Unit\ExampleTest
  ✓ that true is true

   PASS  Tests\Unit\PeminjamanTest
  ✓ generate kode booking format
  ✓ is terlambat returns true when overdue
  ✓ is terlambat returns false when not overdue
  ✓ sisa hari calculation
  ✓ denda calculation formula

   PASS  Tests\Unit\PenggunaTest
  ✓ user is admin
  ✓ user is petugas
  ✓ user is anggota
  ✓ status verifikasi
  ✓ admin can access any feature
  ✓ format nomor anggota

  Tests:    16 passed (41 assertions)
  Duration: 10.23s
  Status:   100% PASS
```

---

## 8. PANDUAN INSTALASI & MENJALANKAN PROGRAM

1. **Persiapan Database**:
   - Buka XAMPP Control Panel, aktifkan service **MySQL**.
   - Database `readify` terhubung pada host `127.0.0.1:3306`, user `root`, tanpa password.
2. **Migrasi & Seeding Data**:
   ```bash
   php artisan migrate
   php artisan db:seed --class=UsersSeeder
   ```
3. **Menjalankan Server Web**:
   ```bash
   php artisan serve --port=8000
   ```
4. **Mengakses Website**:
   Buka browser dan arahkan ke URL: `http://127.0.0.1:8000`

---

## 9. KREDENSIAL PENGUJIAN ASESOR

| Peran | Username / Email | Password | Kegunaan Pengujian |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@readify.id` | `admin123` | Uji tambah buku/kategori, kelola denda, verifikasi anggota, generate laporan |
| **Petugas** | `petugas@readify.id` | `petugas123` | Uji validasi kode booking, proses pengembalian buku, penerimaan denda |
| **Peminjam** | `anggota@readify.id` | `anggota123` | Uji pencarian buku, booking peminjaman, perpanjangan, beri rating & review |

---

*Disusun sebagai pemenuhan berkas unjuk kerja Tugas Praktik Demonstrasi FR.IA.02 Skema Sertifikasi Pemrogram Junior.*
