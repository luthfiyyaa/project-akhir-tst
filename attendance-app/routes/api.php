<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Murid;
use App\Models\Presensi;
use App\Models\DetailPresensi;

Route::get('/presensi', function (Request $request) {
    $murid = Murid::where('api_token', $request->bearerToken())->first();

    if (!$murid) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $presensi = Presensi::with('kelas')
        ->where('kelas_id', $murid->kelas_id)
        ->get();

    return response()->json([
        'murid' => $murid,
        'presensi' => $presensi
    ]);
});


Route::get('/presensi/{id}/detail', function ($id, Request $request) {
    $murid = Murid::where('api_token', $request->bearerToken())->first();

    if (!$murid) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $presensi = Presensi::with(['kelas', 'detailPresensi.murid'])
        ->find($id);

    if (!$presensi) {
        return response()->json(['message' => 'Presensi not found'], 404);
    }

    // Format data agar sesuai
    $detail = [
        'id_presensi' => $presensi->id_presensi,
        'kelas' => [
            'nama_kelas' => $presensi->kelas->nama_kelas ?? null,
        ],
        'tanggal' => $presensi->tanggal,
        'murid' => $presensi->detailPresensi->map(function ($item) {
            return [
                'nama' => $item->murid->nama ?? null,
                'status' => $item->status,
            ];
        })->all(),
    ];

    return response()->json($detail);
});

Route::put('/detail-presensi/{id}', function (Request $request, $id) {
    $murid = Murid::where('api_token', $request->bearerToken())->first();

    if (!$murid) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $detail = DetailPresensi::find($id);

    if (!$detail) {
        return response()->json(['message' => 'Not found'], 404);
    }

    if ($detail->id_murid != $murid->id_murid) {
        return response()->json(['message' => 'Forbidden'], 403);
    }

    $detail->status = $request->input('status');
    $detail->save();

    return response()->json(['message' => 'Updated', 'data' => $detail]);
});



Route::get('/detail-presensi/{id}', function ($id) {
    $presensi = Presensi::with(['kelas', 'detailPresensi.murid'])->find($id);

    if (!$presensi) {
        return response()->json(['message' => 'Not found'], 404);
    }

    return response()->json([
        'id_presensi' => $presensi->id_presensi,
        'kelas' => [
            'nama_kelas' => optional($presensi->kelas)->nama_kelas
        ],
        'tanggal' => $presensi->tanggal,
        'murid' => $presensi->detailPresensi->map(function ($detail) {
            return [
                'id_detail_presensi' => $detail->id_detail_presensi,   
                'id_murid' => $detail->id_murid,
                'nama' => $detail->murid->nama ?? '-',
                'status' => $detail->status
            ];
        }),
    ]);
});


Route::get('/user', function (Request $request) {
    $murid = Murid::where('api_token', $request->bearerToken())->first();

    if (!$murid) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    return response()->json($murid);
});
