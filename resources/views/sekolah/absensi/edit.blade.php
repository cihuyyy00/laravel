@extends('layout.app')

@section('content')

<h2>Edit Data Absensi</h2>

{{-- Nampilinn error validasi --}}

@if ($errors->any())
<div style="color: red">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    
</div>

@endif

<form action="{{ route('absensi.update',$absensi->id) }}" method="post">
    @csrf 
    @method('PUT')

    <div>
    <label>Siswa :</label>
        <label>{{ $absensi->siswa->nama }} </label>
    </div>

    <div>
        <label for="tanggal">Tanggal :</label>
        <input type="date" name="tanggal" id='tanggal' value="{{ old('tanggal', $absensi->tanggal) }}">
    </div><br>
 
    <div>
        <label for="status">Status :</label>
        <select name="status" id="status">
            <@foreach (['Hadir', 'Izin', 'Sakit', 'Alpa'] as $st)
                <option value="{{ $st }}" {{ old('status', $absensi->status) === $st ? 'selected' : '' }}>
                    {{ $st }}
                </option>
            @endforeach
        </select>
    </div><br>

    <button type="submit">Simpan</button>
</form>

@endsection