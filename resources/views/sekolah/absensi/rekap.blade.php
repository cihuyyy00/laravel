<h1>Rekap Absensi Siswa</h1>

<form action="{{ route('absensi.index') }}">
    <button type="submit">Kembali</button>
</form>

<form action="{{ route('absensi.excelRekap') }}">
    <button type="submit">Excel</button>
</form>

<form action="{{ route('absensi.pdfR') }}">
    <button type="submit">PDF</button>
</form>

<!-- filter bulan & taun -->
<form method="get">
    <select name="bulan" id="">
        @foreach (range(1,12) as $b)
            <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                {{ DateTime::createFromFormat('!m', $b)->format('F') }}
            </option>
        @endforeach
    </select>

    <select name="tahun" id="">
        @foreach (range(2025, date('Y')) as $t)
            <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>
                {{ $t }}
            </option>
        @endforeach
    </select>
    
    <button type="submit">Show</button>
</form>

<table border="1" cellpadding="3" cellspacing="5">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Hadir</th>
            <th>Sakit</th>
            <th>Izin</th>
            <th>Alpa</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($rekap as $r)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $r->siswa->nama }} </td>
            <td>{{ $r->total_hadir }} </td>
            <td>{{ $r->total_sakit }} </td>
            <td>{{ $r->total_izin }} </td>
            <td>{{ $r->total_alpa }} </td>
        </tr>
        @endforeach 
    </tbody>
</table>