@extends('layout.app')

@section('content')
<h2>Edit Data Kelas</h2>


<form action="{{ route('mapel.update', $mapel->id) }}" method="POST">
    <!-- csrf biar formny aman -->
    @csrf  
    @method('PUT') 

    <!-- make old biar inputny g ilang pas form gagal -->
    <label>Mapel</label>
    <input type="text" name="nama_mapel" value="{{ old('nama_mapel', $mapel->nama_mapel) }}">

    <label>Kode Mapel</label>
    <input type="text" name="kode_mapel" value="{{ old('kode_mapel', $mapel->kode_mapel) }}">

    <label>Jam Pelajaran</label>
    <input type="text" name="jam_pel" value="{{ old('jam_pel', $mapel->jam_pel) }}">

    <button type="submit">Simpan</button>
</form>

@endsection