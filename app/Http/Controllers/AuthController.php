<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        $bukuPilihan = Buku::with('kategori')->where('stok', '>', 0)->inRandomOrder()->first();
        $totalKoleksi = Buku::count();
        $totalAnggota = Pengguna::where('level_akses', 'anggota')->count();

        return view('auth.login', compact('bukuPilihan', 'totalKoleksi', 'totalAnggota'));
    }

    public function showRegisterForm()
    {
        $totalKoleksi = Buku::count();
        $totalAnggota = Pengguna::where('level_akses', 'anggota')->count();
        $kategoriSemua = Kategori::orderBy('nama_kategori')->get();

        return view('auth.register', compact('totalKoleksi', 'totalAnggota', 'kategoriSemua'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nama_pengguna' => ['required', 'string'],
            'kata_sandi' => ['required', 'string'],
        ]);

        $remember = $request->boolean('ingat_saya') || $request->boolean('remember');

        $authCredentials = [
            'nama_pengguna' => $credentials['nama_pengguna'],
            'password' => $credentials['kata_sandi']
        ];

        if (filter_var($credentials['nama_pengguna'], FILTER_VALIDATE_EMAIL)) {
            $authCredentials = [
                'email' => $credentials['nama_pengguna'],
                'password' => $credentials['kata_sandi']
            ];
        }

        if (Auth::attempt($authCredentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            \App\Models\LogAktivitas::catat('login', "Pengguna '{$user->nama_pengguna}' ({$user->level_akses}) berhasil masuk ke sistem.");

            if ($user->isAdmin()) {
                return redirect()->intended(route('dashboard'));
            } elseif ($user->isPetugas()) {
                return redirect()->intended(route('petugas.dashboard'));
            } elseif ($user->isAnggota()) {
                return redirect()->intended(route('anggota.dashboard'));
            } else {
                return redirect()->intended('/');
            }
        }

        return back()->withErrors([
            'nama_pengguna' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
        ])->onlyInput('nama_pengguna');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nama_pengguna' => ['required', 'string', 'max:100', 'unique:pengguna'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:pengguna'],
            'kata_sandi' => ['required', 'string', 'min:8'],
            'nomor_telepon' => ['required', 'string', 'max:15'],
            'alamat' => ['required', 'string'],
            'preferensi_kategori' => ['nullable', 'array'],
            'preferensi_kategori.*' => ['integer', 'exists:kategori,id_kategori'],
        ]);

        DB::beginTransaction();

        try {
            // Simpan data ke tabel pengguna
            $pengguna = Pengguna::create([
                'nama_pengguna' => $validated['nama_pengguna'],
                'email' => $validated['email'],
                'kata_sandi' => Hash::make($validated['kata_sandi']),
                'level_akses' => 'anggota', // tiap daftar baru otomatis jadi anggota
                'status' => 'pending', // menunggu verifikasi admin
            ]);

            Anggota::create([
                'id_pengguna' => $pengguna->id_pengguna,
                'nama_lengkap' => $validated['nama_lengkap'],
                'alamat' => $validated['alamat'],
                'nomor_telepon' => $validated['nomor_telepon'],
                'preferensi_kategori' => $request->preferensi_kategori ?? [],
                'target_baca_bulanan' => 3,
            ]);

            DB::commit();

            Auth::login($pengguna);

            return redirect()->route('anggota.dashboard');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Waduh, ada masalah pas daftar: ' . $e->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        $userName = Auth::user() ? Auth::user()->nama_pengguna : 'Pengguna';
        \App\Models\LogAktivitas::catat('logout', "Pengguna '{$userName}' keluar dari sistem.");

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
