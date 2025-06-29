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

        $response = Http::withToken($token)
            ->get("http://127.0.0.1:8000/api/presensi/{$id}/detail");

        $data = $response->json();

        return view('presensi.show', [
            'detail' => $data
        ]);
    }

    public function updateDetail(Request $request, $id)
    {
        $token = session('api_token');

        $response = Http::withToken($token)
            ->put("http://127.0.0.1:8000/api/detail-presensi/{$id}", [
                'status' => $request->input('status')
            ]);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Presensi updated!');
        } else {
            return redirect()->back()->with('error', 'Update failed.');
        }
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
