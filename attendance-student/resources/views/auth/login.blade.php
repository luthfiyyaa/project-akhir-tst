@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <h1>Login</h1>
    <form action="{{ route('login') }}" method="POST">
        @csrf
    <div class="form-group">
        <label for="kelas">Kelas</label>
        <select name="kelas" id="kelas" class="form-select" required>
            <option value="">Pilih Kelas</option>
            @foreach($kelas as $k)
                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" class="form-control" name="nama" required>
    </div>

    <button type="submit" class="btn btn-primary">Login</button>
    
        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
    </form>
@endsection
