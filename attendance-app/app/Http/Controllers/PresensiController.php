<?php 

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\DetailPresensi;
use App\Models\Kelas;
use App\Models\Murid;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    public function create()
    {
        $kelas = Kelas::all();
        return view('presensi.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required|date',
        ]);

        // Buat entri presensi untuk kelas
        $presensi = Presensi::create([
            'kelas_id' => $validated['kelas_id'],
            'tanggal' => $validated['tanggal'],
        ]);

        // Ambil semua siswa di kelas tersebut
        $muridList = Murid::where('kelas_id', $validated['kelas_id'])->get();

        // Tambahkan status absensi default untuk setiap murid
        foreach ($muridList as $murid) {
            DetailPresensi::create([
                'presensi_id' => $presensi->id_presensi,
                'id_murid' => $murid->id_murid,
                'status' => 'alpha', // Default status
            ]);
        }

        return redirect()->route('presensi.index')->with('success', 'Presensi berhasil dibuat untuk seluruh siswa!');
    }

    public function show($id)
{
    $presensi = Presensi::with(['kelas', 'detailPresensi.murid'])->findOrFail($id);

    return view('presensi.show', compact('presensi'));
}

    public function index()
    {
        // Ambil data presensi dari database
        $presensi = Presensi::with('kelas')->get(); // Pastikan relasi 'kelas' ada jika digunakan

        // Kembalikan respon dalam format JSON
        return response()->json([
            'status' => 'success',
            'data' => $presensi,
        ]);
    }

    public function edit($id)
    {
        // Ambil data presensi berdasarkan ID
        $presensi = Presensi::findOrFail($id);

        // Ambil data kelas untuk dropdown
        $kelas = Kelas::all();

        // Kirimkan data presensi dan kelas ke view
        return view('presensi.edit', compact('presensi', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required|date',
        ]);

        // Ambil data presensi berdasarkan ID
        $presensi = Presensi::findOrFail($id);

        // Perbarui data presensi (kelas dan tanggal)
        $presensi->update($request->only(['kelas_id', 'tanggal']));

        // Ambil data siswa dari kelas baru
        $muridList = Murid::where('kelas_id', $request->kelas_id)->get();

        // Hapus semua detail presensi lama
        DetailPresensi::where('presensi_id', $presensi->id_presensi)->delete();

        // Tambahkan siswa baru ke detail presensi
        foreach ($muridList as $murid) {
            DetailPresensi::create([
                'presensi_id' => $presensi->id_presensi,
                'id_murid' => $murid->id_murid,
                'status' => 'alpha', // Default status
            ]);
        }

        return redirect()->route('presensi.index')->with('success', 'Data presensi berhasil diperbarui dan daftar siswa telah disesuaikan!');
    }


    public function destroy($id)
    {
        // Cari data presensi berdasarkan ID
        $presensi = Presensi::findOrFail($id);

        // Hapus data presensi
        $presensi->delete();

        return redirect()->route('presensi.index')->with('success', 'Data presensi berhasil dihapus!');
    }
}