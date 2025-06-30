@extends('layouts.app')

@section('title', 'Daftar Presensi')

@section('content')
<div class="container">
    <h1>Daftar Presensi</h1>
    <a href="{{ route('presensi.create') }}" class="btn btn-primary mb-3">Tambah Presensi</a>

    <table class="table table-bordered">
        <thead style="text-align: center">
            <tr>
                <th>#</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Jumlah Siswa</th>
                <th>Detail</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($presensi as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->kelas->nama_kelas }}</td>
                    <td>{{ $data->tanggal }}</td>
                    <td>{{ $data->detailPresensi->count() }}</td>
                    <td>
                        <a href="{{ route('presensi.show', $data->id_presensi) }}" class="btn btn-info btn-sm">Lihat Detail</a>
                    </td>
                    <td>
                        <a href="{{ route('presensi.edit', $data->id_presensi) }}" class="btn btn-outline-info btn-sm">Edit</a>
                        <form action="{{ route('presensi.delete', $data->id_presensi) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</button>
                        </form>
                    </td>
                        
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection