@extends('layout.app')

@section('content')

{{-- Nampilinn notif sukses --}}

@if (session('success'))
<div style="background: #d4edda; padding: 10px; color: black; text-align: center; margin-bottom: 10px; border: 1px solid red;">
    {{ session('success') }}
</div>
@endif

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            text-align: center;
            justify-content: center;
            border: 2px red solid;
        }

        table {
            text-align: center; 
            display: inline-block;
        }

        footer {
            padding: 12px;
        }

        .apusan {
            display: flex;
            gap: 10px;
        }

        .apus:hover {
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>
    <h2>Daftar User</h2>
    
    <form action="{{ route('register') }}">
        @csrf
        <button type="submit">Registrasi</button>
    </form>

<form action="{{ route('users.create') }}">
    <button type="submit">Tambah Data</button>
</form><br>

<form action="{{ route('logout') }}" method="post">
    @csrf
    <button type="submit" onclick="return confirm('Yakin lu logout?')">Logout</button>
</form>

<form action="{{ route('admin.dasbor') }}">
    <button type="submit">Kembali</button>
</form>

<table border="1" cellpadding="10" cellspacing="0" style="margin-top: 20px;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Dibuat</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
        </thead>
        
        <tbody>
            @forelse ($users as $user)
            
            <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td>{{ $user->role }}</td>

                    <td class="apusan">
                        <form action="{{ route('users.edit', $user->id) }}" method="get">
                            @csrf    
                            <button type="submit">Edit</button>
                        </form>

                        <form action="{{ route('users.destroy', $user->id) }}" method="post" style="display: inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="apus" onclick="return confirm('yakin lu mau diapus? &#128527;')">Hapus</button>
                        </form>
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="5">Belom ada data user</td>
                </tr>

                @endempty
            </tbody>
    </table>

</body>
</html>

@endsection