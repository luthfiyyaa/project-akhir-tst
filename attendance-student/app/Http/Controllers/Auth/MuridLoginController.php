<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Murid;
use App\Models\Kelas;
use Illuminate\Support\Str;

class MuridLoginController extends Controller
{
    /**
     * Menampilkan form login untuk murid
     */
    public function showLoginForm()
    {
        $kelas = Kelas::all();

        if ($kelas->isEmpty()) {
            return redirect()->route('home')->withErrors([
                'error' => 'Belum ada data kelas, silakan tambahkan terlebih dahulu.',
            ]);
        }

        return view('auth.login', compact('kelas'));
    }


    /**
     * Memproses login murid
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama'  => 'required|string',
            'kelas' => 'required|string', // 'kelas' diambil dari dropdown kelas
        ]);

        // Cari murid berdasarkan nama dan kelas
        $murid = Murid::where('nama', $request->nama)
            ->where('kelas_id', $request->kelas) // Pastikan 'kelas_id' adalah kolom di database murid
            ->first();

        if ($murid) {
            $murid->api_token = Str::random(60);
            $murid->save();

            Auth::guard('murid')->login($murid);

            session(['api_token' => $murid->api_token]);

            return redirect()->route('presensi.index')
                ->with('success', 'Login berhasil.');
        }

        return back()->withErrors([
            'error' => 'Nama atau kelas salah, silakan coba lagi.',
        ]);
    }

    /**
     * Logout murid
     */
    public function logout()
    {
        // Logout menggunakan Auth
        Auth::guard('murid')->logout();

        // Redirect ke halaman login
        return redirect()->route('login')
            ->with('success', 'Anda telah logout.');
    }
}