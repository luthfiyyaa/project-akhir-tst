@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Presensi</h1>
    <form action="{{ route('presensi.update', $presensi->id_presensi) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="kelas_id" class="form-label">Kelas</label>
            <select name="kelas_id" id="kelas_id" class="form-select" required>
                <option value="">Pilih Kelas</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->id }}" {{ $k->id == $presensi->kelas_id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $presensi->tanggal }}" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('presensi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection