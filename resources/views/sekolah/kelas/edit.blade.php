@extends('layout.app')

@section('content')
<h2>Edit Data Kelas</h2>


<form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
    <!-- csrf biar formny aman -->
    @csrf  
    @method('PUT') 

    <!-- make old biar inputny g ilang pas form gagal -->
    <label>Kelas</label>
    <input type="text" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}">

    <label>Wali Kelass</label>
    <input type="text" name="wali_kelas" value="{{ old('wali_kelas', $kelas->wali_kelas) }}">

    <button type="submit">Simpan</button>
</form>

@endsection