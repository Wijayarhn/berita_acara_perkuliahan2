@extends('layouts.app')

@section('title', 'Detail Jadwal')

@section('contents')
  <div class="container-fluid mt-4">
    <h3 class="mb-4">📘 Detail Jadwal</h3>

    <div class="card mb-4">
      <div class="card-body">
        <h5 class="card-title">{{ $jadwal->nama_mk }} ({{ $jadwal->kode_mk }})</h5>
        <p><strong>Kelas:</strong> {{ $jadwal->kelas }}</p>
        <p><strong>Hari:</strong> {{ $jadwal->hari }}</p>
        <p><strong>Waktu:</strong> {{ $jadwal->waktu }}</p>
        <p><strong>Ruang:</strong> {{ $jadwal->ruang }}</p>
        <p><strong>Dosen:</strong> {{ $jadwal->nama_dosen }}</p>
      </div>
    </div>

    <!-- Tabel Mahasiswa -->
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">👥 Daftar Mahasiswa (Kelas: {{ $jadwal->kelas }})</h5>

        <table class="table-bordered table-striped table">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Nama</th>
              <th>NIM</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($mahasiswa as $index => $mhs)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $mhs->nama }}</td>
                <td>{{ $mhs->nim }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="text-muted text-center">Tidak ada mahasiswa untuk kelas ini.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <a href="{{ route('dosen.jadwal.index') }}" class="btn btn-secondary mt-3">← Kembali</a>
  </div>
@endsection
