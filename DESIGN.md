# Readify Design Direction

> **Project:** Readify — Sistem Informasi Perpustakaan Digital Sekolah & Publik
> **Design Philosophy:** Modern, warm, tactile, and human-centric digital library.
> **Anti-Slop Dials:** ENERGY 2 / RHYTHM 2 / MOTION 1

---

## 1. Brand Identity & Personality

Readify bukan platform SaaS komersial atau startup AI generik. Readify adalah ruang literasi interaktif untuk siswa, guru, petugas, dan komunitas pembaca. 
- **Karakter:** Hangat, terpercaya, terstruktur, rapi, dan mudah diakses oleh semua kalangan.
- **Rasa Visual:** Nuansa perpustakaan klasik yang berpadu dengan kepraktisan teknologi modern (clean paper surfaces, deep forest green bindings, tactile subtle shadows, no hyper-neon gradients).

---

## 2. Color Palette (R-29 Compliant)

Palet warna dibatasi pada 2 warna inti (Core Colors) dan 1 warna aksen (Vibrant Accent):

| Peran | Hex Code | Nama Warna | Penggunaan |
|-------|----------|------------|------------|
| **Core Primary** | `#004236` / `#084734` | Deep Forest Pine | Header, Navbar, Tombol Utama, Judul Utama, Sidebar Aktif |
| **Core Secondary** | `#006e57` / `#0f4c3a` | Classic Library Emerald | Hover states, Header Card, Gradien Halus Internal |
| **Accent Color** | `#87D800` / `#CEF17B` | Fresh Lime Green | Highlight teks terpilih, status aktif, aksen visual penunjuk |
| **Neutral Surface** | `#FFFFFF` & `#F9FAFB` | Clean Paper White | Background kartu, background tabel, panel konten |
| **Neutral Border** | `#E5E7EB` & `#D1D5DB` | Subtle Page Border | Garis pemisah tabel, border kartu, input container |
| **Neutral Text** | `#1F2937` & `#3F3D56` | Slate Charcoal | Teks utama, paragraf, label formulir (Kontras WCAG AA >= 7:1) |
| **Muted Text** | `#4B5563` & `#6B7280` | Reading Graphite | Teks sekunder, metadata penerbit, tanggal (Kontras WCAG AA >= 4.5:1) |

> **Catatan Larangan (R-01):** Dilarang menggunakan gradien ungu-biru, cyan-magenta, atau efek glow neon acak tanpa alasan hierarki informasi.

---

## 3. Typography & Voice (R-06 & R-02 Compliant)

- **Primary Font Family:** `Montserrat`, sans-serif (Google Fonts).
  - Memberikan kesan modern, kokoh, dan mudah dibaca pada berbagai ukuran layar.
- **Monospace Family:** `JetBrains Mono` / `font-mono`.
  - Hanya digunakan untuk data kode teknis: Nomor ISBN, Kode Booking, Kode Batang (Barcode), dan Struk Termal. Dilarang menggunakan monospace untuk judul pemasaran.
- **Larangan Tanda Baca AI (R-02):**
  - **Dilarang keras menggunakan karakter em dash (`—`)** dalam teks antarmuka maupun salinan teks. Gunakan titik dua (`:`), tanda hubung (`-`), koma (`,`), atau tanda kurung `()`.

---

## 4. Iconography (R-04 Compliant)

- **Actual SVG Icons Only:** Seluruh emoji dekoratif dieliminasi dan digantikan dengan ikon SVG vektor yang relevan (Buku, Rak, Kalender, Notifikasi, Tiket, Profil).
- **Larangan AI Sparkle:** Tidak menggunakan simbol bintang 4 sudut / sparkle AI generik untuk merepresentasikan pustakawan atau fitur perpustakaan.

---

## 5. Dials & Liveliness Settings

- **ENERGY: 2 (Balanced)**
  - Tampilan percaya diri dan rapi, menyambut pengguna dengan jelas tanpa kebisingan visual atau elemen floating yang berlebihan.
- **RHYTHM: 2 (Structured with Intentional Breaks)**
  - Menggunakan grid perpustakaan yang rapi untuk katalog buku, diselingi kartu sorotan horizontal dan seksi komunitas berbasis timeline.
- **MOTION: 1 (Calm & Snappy)**
  - Gerakan terbatas pada hover state tombol (transisi 150-200ms), modal open/close yang responsif, dan feedback interaksi yang jelas. Tidak ada animasi mengambang (floating) tanpa henti.
