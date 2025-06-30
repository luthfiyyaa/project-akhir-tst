@extends('layouts.app')

@section('title', 'Daftar Presensi')

@section('content')
    <h1>Daftar Presensi</h1>
        @if($murid && !empty($murid['nama']))
            <p>Login berhasil. <br> Nama murid: {{ $murid['nama'] }}</p>
        @else
            <p>Tidak ada murid yang login.</p>
        @endif

        
    <table class="table table-bordered">
        <thead style="text-align: center">
            <tr>
                <th>ID</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($presensi) && is_array($presensi))
                @foreach ($presensi as $p)
                    <tr>
                        <td>{{ $p['id_presensi'] ?? 'Tidak Ada' }}</td>
                        <td>{{ $p['kelas_id'] ?? 'Tidak Ada' }}</td>
                        <td>{{ $p['tanggal'] ?? 'Tidak Ada' }}</td>
                        <td>
                            <a href="{{ isset($p['id_presensi']) ? route('presensi.show', $p['id_presensi']) : '#' }}"
                            class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </a>

                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" style="text-align: center">Tidak ada data presensi.</td>
                </tr>
            @endif
        </tbody>
    </table>    
@endsection