@extends('layout.app');

@section('content');
<h2>Tambah Data User</h2>

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

<form action="{{ route('users.store') }}" method="post">
    @csrf 
    <div>
        <label>Nama :</label>
        <input type="text" name="name" value="{{ old('name') }}">
    </div><br>

    <div>
        <label>Email :</label>
        <input type="email" name="email" value="{{ old('email') }}">
    </div><br>

    <div>
        <label>Password :</label>
        <input type="password" name="password" value="{{ old('password') }}">
    </div><br>

    <button type="submit">Simpan</button>
</form>

@endsection