@extends('layouts.app')

@section('content')
    <h1>Detail Presensi</h1>
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

@endsection