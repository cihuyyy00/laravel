<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Selamat datang di dashboard</h1>

    <p>halo, disini anda bisa melihat bnyak data yg telah tersimpan di database kami</p>

    <form action="{{ route('mapel.index') }}">
        <button type="submit">Data Mapel</button>
    </form><br>

    <form action="{{ route('guru.index') }}">
        <button type="submit">Data Guru</button>
    </form><br>
    
    <form action="{{ route('kelas.index') }}">
        <button type="submit">Data Kelas</button>
    </form><br>

    <form action="{{ route('siswa.index') }}">
        <button type="submit">Data Siswa</button>
    </form><br>

    <form action="{{ route('absensi.index') }}">
        <button type="submit">Absensi</button>
    </form><br>
    

    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit">Logout</button>
    </form>

</body>
</html>