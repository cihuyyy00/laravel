@extends('layout.app')

@section('content')

<h2>Data Guru</h2>

<form action="{{ route('guru.create') }}">
    <button type="submit">Tambah</button>
</form>


<table border="1" cellspacing="6" cellpadding="5" style="font-family: 'Courier New', Courier, monospace;">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>NIP</th>
        <th>Mapel Utama</th>
        <th>Role</th>
        <th>Data</th>
        <th>Aksi</th>
    </tr>
    
    @foreach ($guru as $g)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $g->nama }}</td>
        <td>{{ $g->nip }}</td>
        <td>{{ $g->mapel_utama }}</td>
        <td>{{ $g->role }}</td>
        <td>
            <form action="{{ route('guru.show', $g->id) }}">
                @csrf
                <button type="submit">Lihat Mapel</button>
            </form>
        </td>
        
        <td style="display: flex; gap: 10px;"> 
            <form action="{{ route('guru.edit', $g->id) }}" method="get">
                @csrf
                <button type="submit">Edit</button>
            </form>

            <form action="{{ route('guru.destroy', $g->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('yakin mau diapus?')">Hapus</button>
            </form>
        </td>
    </tr>

    @endforeach
</table>

@endsection