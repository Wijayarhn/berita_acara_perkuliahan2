@extends('layouts.mahasiswa.app')

@section('title', '📘 Detail Jadwal Kuliah')

@section('contents')
  <div class="container-fluid">

    <div class="card">
      <div class="card-body">
        <h5 class="card-title">{{ $jadwal->nama_mk }} ({{ $jadwal->kode_mk }})</h5>
        <p><strong>Kelas:</strong> {{ $jadwal->kelas }}</p>
        <p><strong>Hari:</strong> {{ $jadwal->hari }}</p>
        <p><strong>Waktu:</strong> {{ $jadwal->waktu }}</p>
        <p><strong>Ruang:</strong> {{ $jadwal->ruang }}</p>
        <p><strong>Dosen:</strong> {{ $jadwal->nama_dosen }}</p>
      </div>
    </div>

    <a href="{{ route('mahasiswa.jadwal.index') }}" class="btn btn-secondary mt-3">← Kembali</a>
  </div>
@endsection
