@extends('layouts.mahasiswa.app')

@section('title', 'Detail BAP')

@section('contents')
  <div class="container-fluid">
    <h4 class="mb-3">📄 Detail Berita Acara</h4>

    <table class="table-bordered table">
      <tr>
        <th>Tanggal</th>
        <td>{{ \Carbon\Carbon::parse($bap->tanggal)->format('d M Y') }}</td>
      </tr>
      <tr>
        <th>Pertemuan</th>
        <td>{{ $bap->pertemuan_ke }}</td>
      </tr>
      <tr>
        <th>Mata Kuliah</th>
        <td>{{ $bap->jadwal->nama_mk ?? '-' }}</td>
      </tr>
      <tr>
        <th>Kelas</th>
        <td>{{ $bap->jadwal->kelas ?? '-' }}</td>
      </tr>
      <tr>
        <th>Materi</th>
        <td>{{ $bap->materi }}</td>
      </tr>
      <tr>
        <th>Pokok Bahasan</th>
        <td>{{ $bap->pokok_bahasan ?? '-' }}</td>
      </tr>
      <tr>
        <th>Deskripsi Tugas</th>
        <td>{{ $bap->deskripsi_tugas ?? '-' }}</td>
      </tr>
      <tr>
        <th>Jumlah Hadir</th>
        <td>{{ $bap->jumlah_hadir }}</td>
      </tr>
      <tr>
        <th>Jumlah Tidak Hadir</th>
        <td>{{ $bap->jumlah_tidak_hadir }}</td>
      </tr>

      {{-- Informasi TTD Mahasiswa --}}
      @php
        $mahasiswaTtd = $bap->bapMahasiswa->firstWhere('mahasiswa_id', auth('mahasiswa')->id());
      @endphp

      <tr>
        <th>Status TTD</th>
        <td>
          @if ($mahasiswaTtd && $mahasiswaTtd->ttd_mahasiswa)
            ✅ Sudah Ditandatangani
          @else
            ❌ Belum Ditandatangani
          @endif
        </td>
      </tr>

      @if ($mahasiswaTtd && $mahasiswaTtd->ttd_mahasiswa)
        <tr>
          <th>Lokasi Mahasiswa</th>
          <td>{{ $mahasiswaTtd->lokasi_mahasiswa }}</td>
        </tr>
        <tr>
          <th>TTD Mahasiswa</th>
          <td>
            <img src="{{ $mahasiswaTtd->ttd_mahasiswa }}" alt="Tanda Tangan" style="max-height: 100px;">
          </td>
        </tr>
      @endif
    </table>

    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">← Kembali</a>
  </div>
@endsection
