<?php

namespace App\Http\Controllers;

use App\Models\DetailPresensi;
use Illuminate\Http\Request;

class DetailPresensiController extends Controller
{
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        $detailPresensi = DetailPresensi::findOrFail($id);
        $detailPresensi->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Status presensi berhasil diperbarui!');
    }
}