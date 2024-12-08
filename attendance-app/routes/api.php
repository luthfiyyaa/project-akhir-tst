<?php

// routes/api.php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/data', function () {
    return response()->json([
        'message' => 'Data from App 1',
        'data' => ['item1', 'item2', 'item3']
    ]);
});

Route::post('/send-data', function (Request $request) {
    return response()->json([
        'received' => $request->all(),
        'status' => 'success'
    ]);
});
