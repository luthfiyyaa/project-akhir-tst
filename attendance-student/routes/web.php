<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Auth\MuridLoginController;
use App\Http\Controllers\PresensiController;

Route::group(['middleware' => ['auth:murid']], function () {
    Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi.index');
    Route::get('/presensi/{id}/detail', [PresensiController::class, 'show'])->name('presensi.show');
});

Route::get('login', [MuridLoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [MuridLoginController::class, 'login']);
Route::post('logout', [MuridLoginController::class, 'logout'])->name('logout');


// Route untuk menampilkan daftar presensi dari aplikasi 1
Route::get('/presensi', function () {
    $response = Http::get('http://127.0.0.1:8000/presensi'); // URL aplikasi 1
    return view('presensi.index', ['presensi' => $response->json()]);
})->name('presensi.index');

// Route untuk menampilkan detail presensi berdasarkan hash_id dari aplikasi 1
Route::get('/presensi/{id}/detail', function ($id) {
    $response = Http::get("http://127.0.0.1:8000/presensi/{$id}/detail"); // URL aplikasi 1
    return view('presensi.detail', ['detail' => $response->json()]);
})->name('presensi.show');

// Route::get('presensi', [PresensiController::class, 'presensi']);
// Route::get('presensi/{id}', [PresensiController::class, 'show'])->name('presensi.show');



// Route default
Route::get('/', function () {
    return view('welcome');
});