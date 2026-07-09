@extends('layout.app')

@section('content')

<h2>Form tambah Mapel untuk Guru : {{ $guru->nama }}</h2>

<form action="{{ route('guru.storeMapel', $guru->id) }}" method="post">
    @csrf

    <label>Pilih Mapel :</label><br>
    @foreach ($mapels as $m)
        <input type="checkbox" name="mapel[]" value="{{ $m->id }}"
        {{ $guru->mapels->contains($m->id) ? 'checked' : '' }}>

        {{ $m->nama_mapel }} ({{ $m->kode_mapel }}) <br>
    
    @endforeach

    <button type="submit">Tambah</button>
</form>
@endsection