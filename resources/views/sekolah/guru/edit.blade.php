@extends('layout.app')

@section('content')
<h2>Edit Data Kelas</h2>


<form action="{{ route('guru.update', $guru->id) }}" method="POST">
    <!-- csrf biar formny aman -->
    @csrf  
    @method('PUT') 

    <!-- make old biar inputny g ilang pas form gagal -->
    <label>Guru</label>
    <input type="text" name="nama" value="{{ old('nama', $guru->nama) }}">

    <label>NIP</label>
    <input type="text" name="nip" value="{{ old('nip', $guru->nip) }}">

    <label>Mapel</label>
    <input type="text" name="mapel_utama" value="{{ old('mapel_utama', $guru->mapel_utama) }}">

    <label>Password</label>
    <input type="text" name="password" value="{{$guru->pw}}">

    <label>Role :</label>
    <input type="radio" name="role" value="Admin">Admin
    <input type="radio" name="role" value="User">User



    <button type="submit">Simpan</button>
</form>

@endsection