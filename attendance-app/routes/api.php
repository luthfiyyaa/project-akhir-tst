<?php

// routes/api.php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Murid;
use App\Models\Presensi;

Route::get('/presensi', function (Request $request) {
    $murid = Murid::where('api_token', $request->bearerToken())->first();
    dd($murid); // cek kelas_id bener ga

    // tes query juga
    $presensi = Presensi::where('kelas_id', $murid->kelas_id)->get();
    dd($presensi);

    return response()->json($presensi);
});

Route::get('/user', function (Request $request) {
    $murid = Murid::where('api_token', $request->bearerToken())->first();
    return response()->json($murid);
});
