<h2>Detail Mapel</h2>

<p><strong>Nama Mapel : {{ $mapel->nama_mapel }}</strong></p>

<form action="{{ route('mapel.addGuru', $mapel->id) }}">
    @csrf
    <button type="submit">Tambah Guru</button>
</form>
<h3>Guru Pengajar :</h3>

<ul>
    @forelse ($mapel->gurus as $mg)
        <li>{{ $mg->nama }} ({{ $mg->nip }})</li>

    @empty
    <li>blom ada data</li>

    @endforelse
</ul>