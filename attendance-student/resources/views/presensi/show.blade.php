@extends('layouts.app')

@section('title', 'Detail Presensi')

@section('content')
    <h1>Detail Presensi</h1>

    @if (!empty($detail) && isset($detail['murid']))
        <p>ID Presensi: {{ $detail['id_presensi'] }}</p>
        <p>Kelas: {{ $detail['kelas']['nama_kelas'] ?? 'Tidak Ada' }}</p>
        <p>Tanggal: {{ $detail['tanggal'] }}</p>

        <h2>Detail Kehadiran</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Murid</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detail['murid'] as $murid)
                <tr>
                    <td>{{ $murid['nama'] }}</td>
                    <td>{{ $murid['status'] }}</td>
                    <td>
                        <form method="POST" action="{{ route('detail-presensi.update', $murid['id_detail_presensi']) }}" class="d-flex gap-2">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-select form-select-sm w-auto" required>
                                <option value="hadir" {{ $murid['status'] == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="sakit" {{ $murid['status'] == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="izin" {{ $murid['status'] == 'izin' ? 'selected' : '' }}>Izin</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="bi bi-check-circle"></i> Update
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada data detail presensi.</p>
    @endif

    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
@endsection
