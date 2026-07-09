@extends('layout.app')

@section('content')

<h2>Tambah Data Kelas</h2>

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

<form action="{{ route('kelas.store') }}" method="post">
    @csrf 
    <div>
        <label>Nama Kelas :</label>
        <input type="text" name="nama_kelas" id='name_kelas'>
    </div><br>

    <div>
        <label>Wali Kelas :</label>
        <input type="text" name="wali_kelas" id='wali_kelas'>
    </div><br>

    <button type="submit">Simpan</button>
</form>

@endsection