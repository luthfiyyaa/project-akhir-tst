<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    public function index(Request $request)
    {
        $token = session('api_token');

        if (!$token) {
            // Belum login
            return view('presensi.index', [
                'murid' => null,
                'presensi' => []
            ]);
        }

        $muridResponse = Http::withToken($token)
            ->get('http://127.0.0.1:8000/api/user')
            ->json();

        $presensiResponse = Http::withToken($token)
            ->get('http://127.0.0.1:8000/api/presensi')
            ->json();

        $murid = $presensiResponse['murid'] ?? null;
        $presensi = $presensiResponse['presensi'] ?? [];

        return view('presensi.index', compact('murid', 'presensi'));
    }

    public function show($id)
    {
        $token = session('api_token');
        $muridId = session('murid_id');

        $response = Http::withToken($token)
            ->get("http://127.0.0.1:8000/api/detail-presensi/{$id}");

        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $detail = $response->json();

        // Filter hanya murid yang login
        $filteredMurid = collect($detail['murid'] ?? [])->filter(function ($m) use ($muridId) {
            return $m['id_murid'] == $muridId;
        })->values()->toArray();

        // Ganti isian murid di array detail
        $detail['murid'] = $filteredMurid;

        return view('presensi.show', compact('detail'));
    }


    public function updateDetail(Request $request, $id)
    {
        $token = session('api_token');
        $muridId = session('murid_id');

        if (!$muridId) {
            return redirect()->back()->with('error', 'Murid tidak ditemukan di session.');
        }

        $validated = $request->validate([
            'status' => 'required|in:hadir,sakit,izin',
        ]);

        $updateResponse = Http::withToken($token)
            ->put("http://127.0.0.1:8000/api/detail-presensi/{$id}", [
                'status' => $validated['status'],
                'id_murid' => $muridId,
            ]);

        if ($updateResponse->successful()) {
            return redirect()->back()->with('success', 'Presensi berhasil diupdate!');
        } else {
            return redirect()->back()->with('error', 'Update gagal dilakukan.');
        }
    }


}
