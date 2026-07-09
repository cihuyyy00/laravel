@extends('layout.app')

@section('content')

<h2>Data Mata Pelajaran</h2>

<form action="{{ route('mapel.create') }}">
    <button type="submit">Tambah</button>
</form>


<table border="1" cellpadding="5" cellspacing="7">
    <tr>
        <th>No</th>
        <th>Mapel</th>
        <th>Kode Mapel</th>
        <th>Jam Pelajaran</th>
        <th>Data Guru</th>
        <th>Aksi</th>
    </tr>
    
    
    @foreach ($mapel as $m)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $m->nama_mapel }}</td>
        <td>{{ $m->kode_mapel }}</td>
        <td style="text-align:center;">{{ $m->jam_pel }}</td>

        <td>
            <form action="{{ route('mapel.show', $m->id) }}" method="get">
                @csrf
                <button type="submit">Lihat Guru</button>
            </form>
        </td>
        
        <td style="display: flex; gap: 5px;">
            <form action="{{ route('mapel.edit', $m->id) }}" method="get">
                @csrf
                <button type="submit">Edit</button>
            </form>
            
            <form action="{{ route('mapel.destroy', $m->id) }}" method="post">
                @csrf
                @method('DELETE')    

                <button type="submit" onclick="return confirm('Yakin dihapus?')">Hapus</button>
            </form>

        </td>
    </tr>
    @endforeach
</table>

@endsection