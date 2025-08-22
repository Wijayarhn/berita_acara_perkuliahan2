@extends('layouts.mahasiswa.app')
@section('title', 'BAP Aktif')

@section('contents')
  <div class="container">
    <h4 class="mb-4">Berita Acara Aktif</h4>

    @if ($bapAktif)
      <div class="card mb-4">
        <div class="card-body">
          <h5>{{ $bapAktif->jadwal->matakuliah }}</h5>
          <p><strong>Tanggal:</strong> {{ $bapAktif->tanggal }}</p>
          <p><strong>Materi:</strong> {{ $bapAktif->materi }}</p>
          <p><strong>Catatan:</strong> {{ $bapAktif->catatan }}</p>

          <form action="{{ route('mahasiswa.bap.ttd', $bapAktif->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Tandatangani</button>
          </form>
        </div>
      </div>
    @else
      <p>Tidak ada BAP aktif untuk saat ini.</p>
    @endif
  </div>
@endsection
