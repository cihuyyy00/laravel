<h2>Detail Guru</h2>

<p>Nama : {{ $guru->nama }}</p>
<p>NIP : {{ $guru->nip }}</p>

<form action="{{ route('guru.addMapel', $guru->id) }}">
    @csrf
    <button type="submit">Tambah Mapel</button>
</form>

<form action="{{ route('guru.index') }}">
    @csrf
    <button type="submit">Kembali</button>
</form>


<h3>Mata Pelajaran yg diampu :</h3>

<h4><strong>Mapel Utama : {{ $guru->mapel_utama }}</strong></h4>

<ul>
    @foreach ($guru->mapels as $gm)
        <li>{{ $gm->nama_mapel }} ({{ $gm->kode_mapel }})</li>

    @endforeach

</ul>