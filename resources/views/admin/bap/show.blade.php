@extends('layouts.admin.app')

@section('title', 'Detail Verifikasi BAP')

@section('contents')
  <div class="container-fluid">
    <h4 class="mb-3">🧾 Detail Berita Acara Perkuliahan</h4>

    <div class="card mb-4 shadow">
      <div class="card-body">
        <a href="{{ route('admin.export.pdf', $bap->id) }}" target="_blank" class="btn btn-danger">
          🧾 Export PDF
        </a>

        <table class="table-bordered table">
          <tr>
            <th width="30%">Dosen</th>
            <td>{{ $bap->dosen->nama }}</td>
          </tr>
          <tr>
            <th>Mata Kuliah</th>
            <td>{{ $bap->jadwal->nama_mk }}</td>
          </tr>
          <tr>
            <th>Kelas</th>
            <td>{{ $bap->jadwal->kelas }}</td>
          </tr>
          <tr>
            <th>Hari / Waktu</th>
            <td>{{ $bap->jadwal->hari }} / {{ $bap->jadwal->waktu }}</td>
          </tr>
          <tr>
            <th>Tanggal</th>
            <td>{{ \Carbon\Carbon::parse($bap->tanggal)->format('d M Y') }}</td>
          </tr>
          <tr>
            <th>Pertemuan Ke</th>
            <td>{{ $bap->pertemuan_ke }}</td>
          </tr>
          <tr>
            <th>Materi</th>
            <td>{{ $bap->materi }}</td>
          </tr>
          <tr>
            <th>Pokok Bahasan</th>
            <td>{{ $bap->pokok_bahasan }}</td>
          </tr>
          <tr>
            <th>Deskripsi Tugas</th>
            <td>{{ $bap->deskripsi_tugas }}</td>
          </tr>
          <tr>
            <th>Jumlah Hadir</th>
            <td>{{ $bap->jumlah_hadir }}</td>
          </tr>
          <tr>
            <th>Jumlah Tidak Hadir</th>
            <td>{{ $bap->jumlah_tidak_hadir }}</td>
          </tr>
          <tr>
            <th>Lokasi Dosen</th>
            <td>
              {{ $bap->lokasi_dosen_nama }}
            </td>
          </tr>
          <tr>
            <th>Status Verifikasi</th>
            <td>
              <span class="badge {{ $bap->status_verifikasi === 'disetujui' ? 'bg-success' : 'bg-warning text-dark' }}">
                {{ ucfirst($bap->status_verifikasi) }}
              </span>
            </td>
          </tr>
          <tr>
            <th>Foto Pembelajaran</th>
            <td>
              @if ($bap->foto_pembelajaran)
                <img src="{{ asset('uploads/dokumentasi/' . $bap->foto_pembelajaran) }}" class="img-fluid" width="300"
                  alt="Dokumentasi">
              @else
                <span class="text-muted">Tidak ada dokumentasi.</span>
              @endif
            </td>
          </tr>
        </table>
      </div>
    </div>

    <div class="card shadow">
      <div class="card-header">
        <strong>✍️ TTD Mahasiswa & Lokasi</strong>
      </div>
      <div class="card-body table-responsive">
        <table class="table-bordered table">
          <thead class="table-light">
            <tr>
              <th>Nama Mahasiswa</th>
              <th>Lokasi (Kota)</th>
              <th>TTD Mahasiswa</th>
            </tr>
          </thead>
          <tbody>
            @php
              $mahasiswaTtd = $bap->bapMahasiswa->filter(fn($bm) => $bm->ttd_mahasiswa);
            @endphp

            @if ($mahasiswaTtd->count() > 0)
              @foreach ($mahasiswaTtd as $bm)
                <tr>
                  <td>{{ $bm->mahasiswa->nama }}</td>
                  <td>{{ $bm->lokasi_nama ?? 'Tidak tersedia' }}</td>
                  <td><span class="text-success">Sudah TTD</span></td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="3" class="text-danger text-center">Belum ada yang TTD</td>
              </tr>
            @endif
          </tbody>

        </table>
      </div>
    </div>

    @if ($bap->status_verifikasi != 'disetujui')
      <form action="{{ route('admin.bap.verifikasi', $bap->id) }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="btn btn-success">✅ Setujui BAP Ini</button>
        <a href="{{ route('admin.bap.index') }}" class="btn btn-secondary">← Kembali</a>
      </form>
    @else
      <a href="{{ route('admin.bap.index') }}" class="btn btn-secondary mt-4">← Kembali</a>
    @endif
  </div>
@endsection
