@extends('layout.app')

@section('content')
<h2>Edit Data User</h2>

{{-- Nampilinn error validasi --}}


<form action="{{ route('users.update', $user->id) }}" method="POST">
    <!-- csrf biar formny aman -->
    @csrf  
    @method('PUT') {{--krna HTML g supprot PUT, jdinya diakali--}}

    <!-- make old biar inputny g ilang pas form gagal -->
    <div>
        <label>Nama :</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}">
    </div>

    <div>
        <label>Email :</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}">
    </div>

    <div>
        <label>Password :</label>
        <input type="password" name="password" value="{{ old('password') }}">
    </div>

    <button type="submit">Update</button>
</form>

@endsection