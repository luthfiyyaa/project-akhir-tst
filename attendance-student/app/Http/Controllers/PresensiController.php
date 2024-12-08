<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    public function index()
    {
        // Panggil API
        $response = Http::get('http://127.0.0.1:8000/api/data');

        // Validasi respons
        if ($response->successful()) {
            $presensi = $response->json(); // Ambil data JSON sebagai array
        } else {
            $presensi = []; // Atur default kosong jika gagal
        }

        // Kirim data ke view
        return view('presensi.index', compact('presensi'));
    }


    public function show($id)
    {
        // Ambil detail data dari API aplikasi 1
        $response = Http::get("http://127.0.0.1:8000/presensi/{$id}/detail");
        return view('presensi.detail', ['detail' => $response->json()]);
    }

    public function presensi()
    {
        $murid = Auth::user();  // Mengambil murid yang sedang login
        $presensi = Http::get('http://127.0.0.1:8000/presensi');  // Ambil presensi berdasarkan murid yang login

        if ($murid) {
            Auth::login($murid);
            dd(Auth::user()); // Periksa apakah data murid tersedia setelah login
            return view('presensi.index', ['presensi' => $presensi]);
        }
    }
}
