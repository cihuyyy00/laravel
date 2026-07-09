@extends('layout.app')

@section('content')

<h2>Form tambah data</h2>

<form action="{{ route('mapel.store') }}" method="post">
    @csrf
    <label>Nama Mapel</label><br>
    <input type="text" name="nama_mapel" id="nama_mapel"><br><br>

    <label>Kode Mapel</label><br>
    <input type="text" name="kode_mapel" id="kode_mapel"><br><br>

    <label>Jam Pelajaran</label><br>
    <input type="text" name="jam_pel" id="jam_pel"><br><br>

    <button type="submit">Tambah</button>
</form>

@endsection