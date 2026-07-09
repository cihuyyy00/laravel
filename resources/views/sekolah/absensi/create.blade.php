@extends('layout.app')

@section('content')

<h2>Tambah Data Absensi</h2>

{{-- Nampilinn error validasi --}}

@if (session('error'))
<div style="color:yellow; border: 1px red solid; padding: 10px; text-align: center; background-color: red; font-weight:bold">
        {{ session('error') }}
</div>
@endif

<form action="{{ route('absensi.store') }}" method="post">
    @csrf 
        
    <table border="1" cellpadding="4" cellspacing="2">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        
        <tbody>
            @foreach ($siswa as $s)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $s->nama}}</td>
                <td><input type="date" name="tanggal" id="tanggal"></td>
                <td>
                    <select name="status[{{ $s->id }}]">
                    <option value="Hadir">Hadir</option>
                    <option value="Izin">Izin</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Alpa">Alpa</option>
                    </select></td>
            </tr>
            @endforeach
        </tbody>

    </table>    

    <button type="submit">Simpan</button>
</form>

<p style="font-size: 10px">*NB : Anda dapat mengisi form diatas lebih mudah, anda tidak perlu mengubah tanggal 
    karena secara default diatur untuk hari ini. Anda hanya dapat mengisi absensi ini 1x1 hari, jika lebih
    maka akan terjadi <b>error</b></p>
@endsection