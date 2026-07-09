<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
</head>
<body>
    <h2 align="center">Laporan data Absensi</h2>
    <table border="1" align="center">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $r)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $r->siswa->nama }}</td>
                    <td>{{ $r->status }}</td>
                    <td>{{ $r->tanggal }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>