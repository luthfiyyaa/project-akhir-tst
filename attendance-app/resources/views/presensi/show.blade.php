@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Presensi</h1>

    <div class="mb-4">
        <h3>Kelas: {{ $presensi->kelas->nama_kelas }}</h3>
        <p>Tanggal: {{ $presensi->tanggal }}</p>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Siswa</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($presensi->detailPresensi as $detail)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $detail->murid->nama }}</td>
                    <td>{{ ucfirst($detail->status) }}</td>
                    <td>
                        <form action="{{ route('detail-presensi.update', $detail->id_detail_presensi) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="hadir" {{ $detail->status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="izin" {{ $detail->status == 'izin' ? 'selected' : '' }}>Izin</option>
                                <option value="sakit" {{ $detail->status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="alpha" {{ $detail->status == 'alpha' ? 'selected' : '' }}>Alpha</option>
                            </select>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('presensi.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection