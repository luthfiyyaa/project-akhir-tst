<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Auth\MuridLoginController;
use App\Http\Middleware\IsSiswa;
use App\Models\Murid;
use App\Http\Controllers\PresensiController;


Route::middleware(['web'])->group(function () {
    Route::get('/', [PresensiController::class, 'index'])->name('presensi.index');

    Route::middleware(['auth:murid', IsSiswa::class])->group(function () {
        Route::get('/presensi/{id}/detail', [PresensiController::class, 'show'])
            ->name('presensi.show');

        Route::put('/detail-presensi/{id}', [PresensiController::class, 'updateDetail'])
            ->name('detail-presensi.update');
    });

    Route::get('login', [MuridLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [MuridLoginController::class, 'login'])->middleware('throttle:5,1');
    Route::post('logout', [MuridLoginController::class, 'logout'])->name('logout');
});

