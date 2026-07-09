@extends('layout.app')

@section('content')
<h2>Edit Data User</h2>

{{-- Nampilinn error validasi --}}


<form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
    <!-- csrf biar formny aman -->
    @csrf  
    @method('PUT') 

    <!-- make old biar inputny g ilang pas form gagal -->
    <label>Nama</label>
    <input type="text" name="nama" value="{{ old('nama', $siswa->nama) }}">

    <label>NIS</label>
    <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}">

    <label>Kelas</label>
    <select name="kelas_id">
        @foreach ($kelas as $k)
            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
        @endforeach
    </select>

    <label>Alamat</label>
    <input type="text" name="alamat" value="{{ old('alamat', $siswa->alamat) }}">

    <button type="submit">Simpan</button>
</form>

@endsection