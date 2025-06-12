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
        $murid = Auth::guard('murid')->user();

        if (!$murid) {
            return redirect()->route('login')->withErrors(['error' => 'Silakan login terlebih dahulu']);
        }

        $response = Http::get('http://127.0.0.1:8000/presensi');

        return view('presensi.index', ['presensi' => $response->json()]);
    }

}
