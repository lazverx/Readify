<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi - {{ $peminjaman->kode_booking }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&family=Montserrat:wght@500;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Courier Prime', Courier, monospace;
            background-color: #f1f5f9;
            color: #0f172a;
            padding: 24px 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .action-bar {
            width: 100%;
            max-width: 360px;
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .btn {
            flex: 1;
            padding: 10px 16px;
            border-radius: 10px;
            font-family: 'Montserrat', sans-serif;
            font-size: 13px;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }
        .btn-print {
            background-color: #004236;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 66, 54, 0.25);
        }
        .btn-print:hover {
            background-color: #003027;
        }
        .btn-back {
            background-color: #ffffff;
            color: #475569;
            border: 1px solid #cbd5e1;
        }
        .btn-back:hover {
            background-color: #f8fafc;
        }
        .receipt {
            width: 100%;
            max-width: 360px;
            background: #ffffff;
            padding: 24px 20px;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
            font-size: 12px;
            line-height: 1.45;
        }
        .center {
            text-align: center;
        }
        .right {
            text-align: right;
        }
        .logo-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 0.05em;
            color: #004236;
            text-transform: uppercase;
        }
        .sub-title {
            font-size: 11px;
            color: #64748b;
            margin-top: 2px;
        }
        .divider {
            border: none;
            border-top: 1px dashed #94a3b8;
            margin: 12px 0;
        }
        .divider-solid {
            border: none;
            border-top: 1px solid #334155;
            margin: 12px 0;
        }
        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .row .label {
            color: #475569;
        }
        .row .val {
            font-weight: 700;
            text-align: right;
            max-width: 60%;
            word-break: break-word;
        }
        .badge-status {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-lunas {
            background-color: #dcfce7;
            color: #15803d;
        }
        .badge-belum {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        .badge-dipinjam {
            background-color: #e0f2fe;
            color: #0369a1;
        }
        .barcode {
            margin: 16px auto 8px auto;
            text-align: center;
        }
        .barcode-bars {
            font-family: monospace;
            font-size: 24px;
            letter-spacing: 4px;
            transform: scaleY(1.4);
            display: inline-block;
            font-weight: 900;
        }
        .footer-note {
            font-size: 10px;
            color: #64748b;
            margin-top: 14px;
            text-align: center;
            font-style: italic;
        }

        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .action-bar {
                display: none;
            }
            .receipt {
                max-width: 100%;
                box-shadow: none;
                border: none;
                padding: 10px;
            }
        }
    </style>
</head>
<body>

    <div class="action-bar">
        <button class="btn btn-print" onclick="window.print()" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg style="width: 16px; height: 16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak Struk
        </button>
        <button class="btn btn-back" onclick="window.close(); if(!window.closed) history.back();" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg style="width: 16px; height: 16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </button>
    </div>

    <div class="receipt">
        <!-- HEADER PERPUSTAKAAN -->
        <div class="center">
            <div class="logo-title">READIFY LIBRARY</div>
            <div class="sub-title">Sistem Perpustakaan Digital Berstandar BNSP</div>
            <div class="sub-title">Jl. Perpustakaan Pintar No. 42 • Telp: (021) 7788-9900</div>
        </div>

        <hr class="divider">

        <!-- METADATA STRUK -->
        <div class="row">
            <span class="label">No. Struk:</span>
            <span class="val">STRUK-{{ str_pad($peminjaman->id_peminjaman, 6, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="row">
            <span class="label">Kode Booking:</span>
            <span class="val">{{ $peminjaman->kode_booking }}</span>
        </div>
        <div class="row">
            <span class="label">Waktu Cetak:</span>
            <span class="val">{{ now()->format('d/m/Y H:i') }}</span>
        </div>
        <div class="row">
            <span class="label">Operator/Kasir:</span>
            <span class="val">{{ auth()->user()->nama_pengguna }}</span>
        </div>

        <hr class="divider">

        <!-- DATA ANGGOTA -->
        <div class="row">
            <span class="label">No. Anggota:</span>
            <span class="val">{{ $peminjaman->pengguna->nomor_anggota ?? 'AGT-' . $peminjaman->id_pengguna }}</span>
        </div>
        <div class="row">
            <span class="label">Nama Anggota:</span>
            <span class="val">{{ $peminjaman->pengguna->anggota->nama_lengkap ?? $peminjaman->pengguna->nama_pengguna }}</span>
        </div>

        <hr class="divider">

        <!-- DETAIL BUKU -->
        <div style="font-weight: 700; margin-bottom: 6px; color: #004236;">DETAIL SIRKULASI BUKU</div>
        <div class="row">
            <span class="label">Judul Buku:</span>
            <span class="val">{{ $peminjaman->buku->judul_buku ?? 'Buku Perpustakaan' }}</span>
        </div>
        <div class="row">
            <span class="label">Penulis:</span>
            <span class="val">{{ $peminjaman->buku->penulis ?? '-' }}</span>
        </div>
        <div class="row">
            <span class="label">Lokasi Rak:</span>
            <span class="val">{{ $peminjaman->buku->lokasi_rak ?? 'Koleksi Utama' }}</span>
        </div>

        <hr class="divider">

        <!-- WAKTU SIRKULASI -->
        <div class="row">
            <span class="label">Tgl. Pinjam:</span>
            <span class="val">{{ $peminjaman->tgl_pinjam ? \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d M Y') : '-' }}</span>
        </div>
        <div class="row">
            <span class="label">Jatuh Tempo:</span>
            <span class="val" style="color: #b91c1c;">
                {{ $peminjaman->tgl_jatuh_tempo ? \Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo)->format('d M Y') : ($peminjaman->tgl_kembali ? \Carbon\Carbon::parse($peminjaman->tgl_kembali)->format('d M Y') : '-') }}
            </span>
        </div>
        @if($peminjaman->status_transaksi === 'dikembalikan')
            <div class="row">
                <span class="label">Tgl. Kembali:</span>
                <span class="val" style="color: #15803d;">{{ \Carbon\Carbon::parse($peminjaman->diperbarui_pada ?? now())->format('d M Y') }}</span>
            </div>
        @endif
        <div class="row">
            <span class="label">Status Sirkulasi:</span>
            <span class="val">
                <span class="badge-status {{ $peminjaman->status_transaksi === 'dikembalikan' ? 'badge-lunas' : 'badge-dipinjam' }}">
                    {{ strtoupper($peminjaman->status_transaksi) }}
                </span>
            </span>
        </div>

        <hr class="divider-solid">

        <!-- RINCIAN BIAYA & DENDA -->
        @php
            $denda = $peminjaman->denda;
            $jumlahDenda = $denda ? $denda->jumlah_denda : 0;
            $statusDenda = $denda ? $denda->status_pembayaran : 'lunas';
        @endphp

        <div class="row">
            <span class="label">Biaya Pinjam:</span>
            <span class="val">Rp 0 (Gratis)</span>
        </div>
        <div class="row">
            <span class="label">Denda Terlambat:</span>
            <span class="val {{ $jumlahDenda > 0 ? 'text-red-600' : '' }}">
                Rp {{ number_format($jumlahDenda, 0, ',', '.') }}
            </span>
        </div>
        <div class="row">
            <span class="label">Status Biaya:</span>
            <span class="val">
                @if($jumlahDenda > 0)
                    @if($statusDenda === 'lunas')
                        <span class="badge-status badge-lunas">LUNAS</span>
                    @else
                        <span class="badge-status badge-belum">BELUM LUNAS</span>
                    @endif
                @else
                    <span class="badge-status badge-lunas">BEBAS DENDA</span>
                @endif
            </span>
        </div>

        <hr class="divider">

        <!-- BARCODE & TANDA TANGAN -->
        <div class="barcode">
            <div class="barcode-bars">|| | ||| || ||| | |||</div>
            <div style="font-size: 11px; font-weight: 700; margin-top: 4px;">{{ $peminjaman->kode_booking }}</div>
        </div>

        <div style="margin-top: 18px; display: flex; justify-content: space-between; font-size: 10px;">
            <div class="center" style="width: 45%;">
                <div>Peminjam,</div>
                <div style="height: 38px;"></div>
                <div style="border-top: 1px dotted #64748b; font-weight: 700;">
                    {{ Str::limit($peminjaman->pengguna->anggota->nama_lengkap ?? $peminjaman->pengguna->nama_pengguna, 18) }}
                </div>
            </div>
            <div class="center" style="width: 45%;">
                <div>Petugas Kasir,</div>
                <div style="height: 38px;"></div>
                <div style="border-top: 1px dotted #64748b; font-weight: 700;">
                    {{ Str::limit(auth()->user()->nama_pengguna, 18) }}
                </div>
            </div>
        </div>

        <div class="footer-note">
            "Buku adalah jendela dunia.<br>Harap rawat buku dan kembalikan tepat waktu."<br>
            ~ Terima kasih telah berkunjung ke Readify ~
        </div>
    </div>

</body>
</html>
