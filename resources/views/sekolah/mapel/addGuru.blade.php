@extends('layout.app')

@section('content')

<h2>Form tambah Guru untuk Mapel : {{ $mapel->nama_mapel }}</h2>

<form action="{{ route('mapel.storeGuru', $mapel->id) }}" method="post">
    @csrf

    <label>Pilih Guru :</label><br>

    <!-- $mapel->gurus itu baliknya ke models, sama di bag. checked itu biar auto ceklis klo udh di isi sebelumnya -->
    @foreach ($guru as $g)
        <input type="checkbox" name="guru[]" value="{{ $g->id }}"

        {{ $mapel->gurus->contains($g->id) ? 'checked' : '' }}>  

        {{ $g->nama }} ({{ $g->nip }}) <br>
    
    @endforeach

    <button type="submit">Tambah</button>
</form>
@endsection