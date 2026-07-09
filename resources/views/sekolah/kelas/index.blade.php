@extends('layout.app')

@section('content')

<hr>

<h2>Data Kelas</h2>

<hr>
<form action="{{ route('kelas.create') }}">
    <button type="submit">Tambah</button>
</form>

<table border="1" cellspacing="6" cellpadding="5" style="font-family: 'Courier New', Courier, monospace;">
    <thead>
        <tr>
            <th>No</th>
            <th>Kelas</th>
            <th>Wali Kelas</th>
            <th>Aksi</th>
        </tr>
    </thead>
        
        <tbody>
            @foreach ($kelas as $k)
            
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $k->nama_kelas }}</td>
                    <td>{{ $k->wali_kelas }}</td>

                    
                    
                    <td style="display: flex; gap: 10px;"> 
                        <form action="{{ route('kelas.show', $k->id) }}">
                            <button type="submit">Lihat Siswa</button>
                        </form>    
                        
                        <form action="{{ route('kelas.edit', $k->id) }}" method="get">
                            @csrf
                            <button type="submit">Edit</button>
                        </form>

                        <form action="{{ route('kelas.destroy', $k->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('yakin mau diapus?')">Hapus</button>
                        </form> 
                    </td>
                </tr>
            @endforeach
        </tbody>
</table>

@endsection