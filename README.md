# 📚 Readify – Sistem Perpustakaan Digital Modern

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

---

## 🔹 Tentang Readify

Readify adalah platform perpustakaan digital berbasis web yang memudahkan pengelolaan buku, peminjaman, ulasan, koleksi pribadi, dan laporan. Sistem ini dirancang supaya perpustakaan lebih cepat, transparan, dan interaktif dengan tampilan modern yang responsif di berbagai perangkat. Dibangun menggunakan **Laravel 12** dan **Tailwind CSS 4**, fokus pada performa tinggi dan pengalaman pengguna yang nyaman.

---

## 🧩 Fitur Berdasarkan Peran

Sistem ini menggunakan Multi Role sehingga tiap pengguna hanya melihat fitur yang relevan.

### 🏰 Administrator / Owner
- 📊 **Dashboard Visual** – Statistik & grafik real-time.
- 🔑 **Manajemen Perms** – Atur izin secara fleksibel.
- 📝 **Pengawasan Pengajuan Buku** – Setujui/tolak request buku anggota.
- 📂 **Laporan Cepat** – Generate laporan PDF & Excel.
- 🔔 **Notifikasi** – Semua update penting langsung muncul.

### 👮 Petugas / Staff
- ⚡ **Peminjaman & Pengembalian Cepat** – Semua transaksi di satu layar.
- 📚 **Inventory Control** – Update metadata buku, kategori, dan stok.
- 🏷️ **Verifikasi Booking Anggota** – Pastikan buku sesuai pesanan.
- 🔔 **Notifikasi Real-time** – Aktivitas anggota dan sistem langsung terlihat.

### 👤 Anggota / Member
- 🔍 **Cari Buku Pintar** – Filter dan jelajah katalog mudah.
- 🗓️ **Reservasi Mandiri** – Booking buku agar tidak kehabisan.
- 📖 **Koleksi Saya** – Lihat daftar buku favorit dan yang sedang dipinjam.
- ✏️ **Ulasan Buku** – Tulis review untuk buku yang sudah dibaca.
- 📨 **Request Buku Baru** – Ajukan buku dan pantau status lewat notifikasi.

- 💳 **Riwayat & Denda Transparan** – Semua catatan jelas terlihat.
- 🔔 **Notifikasi Real-time** – Update peminjaman, pengembalian, dan pesan sistem.

---

## ⚡ Teknologi
- **Framework**: Laravel 12  
- **Styling**: Tailwind CSS 4  
- **Frontend Interaktif**: Alpine.js & Blade UI Kit  
- **Database**: MySQL / MariaDB  
- **Build Tool**: Vite 6  
- **Grafik & Statistik**: ApexCharts  

---

## 🚀 Instalasi Lokal

### 1️⃣ Persiapan
Pastikan sudah ada:
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL / MariaDB

### 2️⃣ Clone & Install Dependencies
```bash
git clone https://github.com/lazverx/Readify.git
cd Readify
composer install
npm install

# 3️⃣ Konfigurasi Environment
cp .env.example .env
php artisan key:generate

# Edit file .env sesuai database lokal
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=username
DB_PASSWORD=password

# 4️⃣ Migrasi & Seed Data
php artisan migrate --seed

# 5️⃣ Jalankan Aplikasi
# Buka 2 terminal

# Terminal 1: compile asset frontend
npm run dev

# Terminal 2: jalankan server Laravel
php artisan serve

# Akses aplikasi di browser
http://localhost:8000

# 🔑 Akun Demo
# Role        Email                  Password
# Administrator  admin@readify.id     admin123
# Petugas        petugas@readify.id   petugas123
# Anggota        anggota@readify.id   anggota123
