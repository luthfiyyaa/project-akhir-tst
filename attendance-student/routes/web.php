<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Auth\MuridLoginController;
use App\Http\Middleware\IsSiswa;
use App\Models\Murid;
use App\Http\Controllers\PresensiController;


Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        $token = session('api_token');

        $presensi = Http::withToken($token)
            ->get('http://127.0.0.1:8000/api/presensi')
            ->json();

        $murid = Http::withToken($token)
            ->get('http://127.0.0.1:8000/api/user')
            ->json();

        return view('presensi.index', [
            'presensi' => $presensi,
            'murid' => $murid,
        ]);
    })->name('presensi.index');



    Route::middleware(['auth:murid', IsSiswa::class])->group(function () {
        Route::get('/presensi/{id}/detail', function ($id) {
            $response = Http::get("http://127.0.0.1:8000/presensi/{$id}/detail");
            return view('presensi.detail', ['detail' => $response->json()]);
        })->name('presensi.show');
    });

    Route::get('login', [MuridLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [MuridLoginController::class, 'login'])->middleware('throttle:5,1');
    Route::post('logout', [MuridLoginController::class, 'logout'])->name('logout');
});
