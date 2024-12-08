@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Buat Presensi Baru</h1>
    <form action="{{ route('presensi.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="kelas_id" class="form-label">Kelas</label>
            <select name="kelas_id" id="kelas_id" class="form-select" required>
                <option value="">Pilih Kelas</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Buat Presensi</button>
    </form>
</div>
@endsection