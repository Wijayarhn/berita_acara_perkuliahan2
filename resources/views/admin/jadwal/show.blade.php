@extends('layouts.admin.app')

@section('title', 'Detail Jadwal')

@section('contents')
  <div class="container-fluid">
    <div class="card rounded-4 shadow-sm">
      <div class="card-header bg-dark text-white">
        <h4 class="mb-0">Detail Jadwal dan Daftar Mahasiswa</h4>
      </div>
      <div class="card-body">
        {{-- Detail Jadwal --}}
        <div class="card rounded-3 mb-4 border-0 shadow-sm">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Jadwal</h5>
          </div>
          <div class="card-body">
            <div class="row mb-2">
              <div class="col-md-6"><strong>Mata Kuliah:</strong> {{ $jadwal->nama_mk }}</div>
              <div class="col-md-6"><strong>Kode MK:</strong> {{ $jadwal->kode_mk }}</div>
            </div>
            <div class="row mb-2">
              <div class="col-md-6"><strong>Dosen:</strong> {{ $jadwal->nama_dosen }}</div>
              <div class="col-md-6"><strong>Kelas:</strong> {{ $jadwal->kelas }}</div>
            </div>
            <div class="row mb-2">
              <div class="col-md-6"><strong>Hari:</strong> {{ $jadwal->hari }}</div>
              <div class="col-md-6"><strong>Waktu:</strong> {{ $jadwal->waktu }}</div>
            </div>
            <div class="row mb-2">
              <div class="col-md-6"><strong>Ruang:</strong> {{ $jadwal->ruang }}</div>
              <div class="col-md-6"><strong>Program Studi:</strong> {{ $jadwal->prodi }}</div>
            </div>
          </div>
        </div>

        {{-- Daftar Mahasiswa --}}
        <div class="card rounded-3 border-0 shadow-sm">
          <div class="card-header bg-secondary text-white">
            <h6 class="mb-0">Daftar Mahasiswa - Kelas {{ $jadwal->kelas }}</h6>
          </div>
          <div class="card-body p-0">
            <table class="table-bordered mb-0 table">
              <thead class="table-light">
                <tr>
                  <th style="width: 50px;">No</th>
                  <th>Nama</th>
                  <th>NIM</th>
                </tr>
              </thead>
              <tbody>
                @forelse($mahasiswa as $mhs)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $mhs->nama }}</td>
                    <td>{{ $mhs->nim }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="3" class="text-center">Tidak ada mahasiswa di kelas ini.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      {{-- Tombol Kembali --}}
      <div class="card-footer bg-white text-end">
        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-outline-secondary">
          <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
      </div>
    </div>
  </div>
@endsection
