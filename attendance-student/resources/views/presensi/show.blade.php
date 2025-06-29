@extends('layouts.app')

@section('content')
    <h1>Detail Presensi</h1>

    @if (!empty($detail))
        <p>ID Presensi: {{ $detail['id_presensi'] }}</p>
        <p>Kelas: {{ $detail['kelas']['nama_kelas'] ?? 'Tidak Ada' }}</p>
        <p>Tanggal: {{ $detail['tanggal'] }}</p>

        <h2>Detail Kehadiran</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Murid</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detail['murid'] ?? [] as $murid)
                    <tr>
                        <td>{{ $murid['nama'] }}</td>
                        <td>{{ $murid['status'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Isi Presensi:</h3>
        <form method="POST" action="{{ route('detail-presensi.update', $detail['id_presensi']) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id_murid" value="{{ session('murid_id') }}">
            <label>Status:</label>
            <select name="status" required>
                <option value="hadir">Hadir</option>
                <option value="alpha">Alpha</option>
                <option value="izin">Izin</option>
            </select>
            <button type="submit" class="btn btn-primary mt-2">Simpan Presensi</button>
        </form>
    @else
        <p>Tidak ada data detail presensi.</p>
    @endif

    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
@endsection
