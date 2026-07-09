@extends('layout.app')

@section('content')

<h2>Tambah Data Guru</h2>

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

<form action="{{ route('guru.store') }}" method="post">
    @csrf 
    <div>
        <label>Nama Guru :</label>
        <input type="text" name="nama" id='nama'>
    </div><br>

    <div>
        <label>NIP :</label>
        <input type="text" name="nip" id='nip'>
    </div><br>

    <div>
        <label>Mapel :</label>
        <input type="text" name="mapel_utama" id='mapel_utama'>
    </div><br>
    
    <div>
        <label>Password :</label>
        <input type="password" name="pw" id='pw'>
    </div><br>
    
    <div>
        <label>Role :</label>
        <input type="radio" name="role" value="Admin">
        <label for="Admin">Admin</label>
        <input type="radio" name="role" value="User">
        <label for="User">User</label>

    </div><br>

    <button type="submit">Simpan</button>
</form>

@endsection