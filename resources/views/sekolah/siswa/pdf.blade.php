<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
</head>
<body>
    <h2 align="center">Laporan data Siswa</h2>
    <table border="1" align="center">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Wali</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($siswa as $s)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $s->nama }}</td>
                    <td>{{ $s->kelas->nama_kelas }}</td>
                    <td>{{ $s->kelas->wali_kelas }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>