@extends('layout.app')

@section('content')

<form action="{{ route('siswa.store') }}" method="post">
    @csrf

<label>Nama</label><br>
<input type="text" name="nama" placeholder="Nama Siswa" required><br><br>

<label>NIS</label><br>
<input type="text" name="nis" placeholder="NIS" required><br><br>

<label>Kelas</label>
<select name="kelas_id">
    @foreach ($kelas as $k)
        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
    @endforeach
</select><br><br>

<label>Alamat</label><br>
<input type="textarea" name="alamat" placeholder="Alamat" required><br><br>


<button type="submit">Tambah</button>

</form>

@endsection