@extends('layout.app')

@section('content')

@if (session('error'))
    <div style="color:yellow; border: 1px red solid; padding: 10px; text-align: center; background-color: red;">
        {{ session('error') }}
    </div>
@endif

 @if (session('success'))
        <div style="background: #d4edda; padding: 10px; color: black; text-align: center; margin-bottom: 10px; border: 1px solid red;">
            {{ session('success') }}
        </div>
        
    @endif

<hr>

<h2>Data Absen</h2>

<hr>

<!-- search -->
 <div style="display: flex; gap:10px">
    <form action="{{ route('absensi.index') }}" method="get">
        <input type="text" name="keyword" placeholder="Cari siswa..." value="{{ request('keyword') }}">
        
        <select name="kelas_id">
            <option value="">-- Semua Kelas --</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
        </select>
        
        <button type="submit">Cari</button>
    </form>

<div style="display: flex; gap: 10px;">
    <form action="{{ route('absensi.create') }}">
        <button type="submit">Tambah</button>
    </form>
    <form action="{{ route('admin.dasbor') }}">
        <button type="submit">Dasbor</button>
    </form>

    <form action="{{ route('absensi.rekap') }}">
        <button type="submit">Rekapan</button>
    </form>

    <form action="{{ route('absensi.pdf') }}">
        <button type="submit">PDF</button>
    </form>

    <form action="{{ route('absensi.export') }}">
        <button type="submit">Excel</button>
    </form>
</div>
</div>

<p style="font-size: 10px">*Note : Anda hanya dapat menambah atau memasukkan data 1x1 hari, semua data sudah terlihat. 
    anda dapat mengedit dan juga menghapus data. Jika ada kesalahan dalam penulisan data ini
    harap hubungi staff media. Terima kasih
</p>

<table border="1" cellspacing="6" cellpadding="5" style="font-family: 'Courier New', Courier, monospace;">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
        
        <tbody>
            @foreach ($absensi as $a)
            
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="width: 5cm;">{{ $a->siswa->nama }}</td>
                    <td>{{ $a->siswa->kelas->nama_kelas }}</td>
                    <td style="width: 3cm; text-align: center;">{{ $a->tanggal }}</td>
                    <td>{{ $a->status }}</td>  
                        
                    <td style="display: flex; gap: 8px;">
                        <form action="{{ route('absensi.edit', $a->id) }}" method="get">
                            @csrf
                            <button type="submit">Edit</button>
                        </form>

                        <form action="{{ route('absensi.destroy', $a->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('yakin mau diapus?')">Hapus</button>
                        </form> 
                    </td>
                </tr>
            @endforeach
        </tbody>
</table>

{{ $absensi->links() }}


@endsection