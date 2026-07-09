@extends('layout.app')

@section('content')

<hr>

<h2>Data Siswa</h2>
<form action="{{ route('admin.dasbor') }}">
    <button type="submit">Dasbor</button>
</form>

<hr>

<!-- notif -->
    @if (session('success'))
        <div style="background: #d4edda; padding: 10px; color: black; text-align: center; margin-bottom: 10px; border: 1px solid red;">
            {{ session('success') }}
        </div>
        
    @endif




<div style="display: flex; gap: 6px;">

    <form action="{{ route('siswa.create') }}">
        <button type="submit">Tambah</button>
    </form>

    <form action="{{ route('kelas.index') }}">
        <button type="submit">Kelas</button>
    </form>

    <!-- search -->
    <form action="{{ route('siswa.index') }}" method="get">
        <input type="text" name="keyword" placeholder="cari siswa..." value="{{ request('keyword') }}">
        
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

    <form action="{{ route('siswa.export') }}">
        <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="10" height="10" viewBox="0 0 48 48">
        <path fill="#169154" d="M29,6H15.744C14.781,6,14,6.781,14,7.744v7.259h15V6z"></path><path fill="#18482a" d="M14,33.054v7.202C14,
        41.219,14.781,42,15.743,42H29v-8.946H14z"></path><path fill="#0c8045" d="M14 15.003H29V24.005000000000003H14z"></path><path
        fill="#17472a" d="M14 24.005H29V33.055H14z"></path><g><path fill="#29c27f" d="M42.256,6H29v9.003h15V7.744C44,6.781,43.219,6,42.256,6z">
        </path><path fill="#27663f" d="M29,33.054V42h13.257C43.219,42,44,41.219,44,40.257v-7.202H29z"></path><path fill="#19ac65" d="M29 15.003H44V24.
        005000000000003H29z"></path><path fill="#129652" d="M29 24.005H44V33.055H29z"></path></g><path fill="#0c7238" d="M22.319,34H5.681C4.753,34,4,33.
        247,4,32.319V15.681C4,14.753,4.753,14,5.681,14h16.638 C23.247,14,24,14.753,24,15.681v16.638C24,33.247,23.247,34,22.319,34z"></path>
        <path fill="#fff" d="M9.807 19L12.193 19 14.129 22.754 16.175 19 18.404 19 15.333 24 18.474 29 16.123 29 14.013 25.07 11.912 29 9.526 29 12.719
        23.982z"></path>
        </svg></button>
    </form>

    <form action="{{ route('siswa.pdf') }}">
        <button type="submit"><img src="https://www.bing.com/th/id/OIP.gXL-biK94Y1PisQZ49fWEQHaHa?w=206&h
        =211&c=8&rs=1&qlt=70&o=7&cb=thws5&dpr=1.3&pid=3.1&rm=3" width="10" height="10"></button>
    </form>

    <form action="{{ route('siswa.import') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Import</button>
    </form>
</div><br>


<table border="1" cellspacing="6" cellpadding="5" style="font-family: 'Courier New', Courier, monospace;">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIS</th>
            <th>Kelas</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>
        
        <tbody>
            @foreach ($siswa as $s)
            
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $s->nama }}</td>
                    <td>{{ $s->nis }}</td>
                    <td style="text-align: center;">{{ $s->kelas->nama_kelas }}</td>
                    <td>{{ $s->alamat }}</td>

                    <td style="display: flex; gap: 10px;"> 
                        <form action="{{ route('siswa.edit', $s->id) }}" method="get">
                            @csrf
                            <button type="submit">Edit</button>
                        </form>

                        <form action="{{ route('siswa.destroy', $s->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('yakin mau diapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
</table>

{{ $siswa->links() }}

@endsection

