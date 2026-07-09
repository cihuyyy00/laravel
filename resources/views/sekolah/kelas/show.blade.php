@extends('layout.app')

@section('content')

<h2>Detail Kelas : {{ $kelas->nama_kelas }}</h2>
<p>Wali Kelas : {{ $kelas->wali_kelas }}</p>

<h3>Daftar Siswa</h3>

<table border="1" cellspacing="5" cellpadding="6" ">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>NIS</th>
        <th>Alamat</th>
    </tr>

    @forelse ($kelas->siswa as $s)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $s->nama }}</td>
        <td>{{ $s->nis }}</td>
        <td>{{ $s->alamat }}</td>
    </tr>

    @empty
    <tr>
        <td>Belom ada siswa</td>
    </tr>
    @endforelse

</table>

@endsection
