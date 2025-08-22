@extends('layouts.app')
@section('title', 'Detail BAP')

@section('contents')
  <div class="container-fluid">

    <h3 class="mb-4">📄 Detail Berita Acara</h3>

    <table class="table-bordered table-striped table">
      <a href="{{ route('dosen.bap.pdf', $bap->id) }}" class="btn btn-danger me-2" target="_blank">🖨 Export ke PDF</a>

      <tr>
        <th>Tanggal</th>
        <td>{{ \Carbon\Carbon::parse($bap->tanggal)->format('d M Y') }}</td>
      </tr>
      <tr>
        <th>Pertemuan Ke-</th>
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
        <th>Jumlah Mahasiswa Hadir</th>
        <td>{{ $bap->jumlah_hadir }}</td>
      </tr>
      <tr>
        <th>Jumlah Tidak Hadir</th>
        <td>{{ $bap->jumlah_tidak_hadir }}</td>
      </tr>
      <tr>
        <th>Lokasi</th>
        <td>
          {{ $bap->lokasi_dosen_nama }}
          @if ($bap->lokasi_dosen)
            <br><small class="text-muted">Koordinat: {{ $bap->lokasi_dosen }}</small>
          @endif
        </td>
      </tr>
      <tr>
        <th>Status Verifikasi</th>
        <td>
          @if ($bap->status_verifikasi == 'pending')
            <span class="badge bg-warning text-dark">Pending</span>
          @elseif ($bap->status_verifikasi == 'verified')
            <span class="badge bg-success">Terverifikasi</span>
          @elseif ($bap->status_verifikasi == 'rejected')
            <span class="badge bg-danger">Ditolak</span>
          @endif
        </td>
      </tr>
      @if ($bap->catatan_verifikasi)
        <tr>
          <th>Catatan Verifikasi</th>
          <td>{{ $bap->catatan_verifikasi }}</td>
        </tr>
      @endif
      <tr>
        <th>Dokumentasi</th>
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

    <h5>👥 Daftar Mahasiswa (Kelas: {{ $bap->jadwal->kelas ?? '-' }})</h5>
    <table class="table-bordered table-hover table">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Nama Mahasiswa</th>
          <th>NIM</th>
          <th>Kehadiran</th>
          <th>Memberi TTD</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($bap->mahasiswa as $index => $mhs)
          @php
            $bapMhs = $bap->bapMahasiswa->firstWhere('mahasiswa_id', $mhs->id);
            $sudahTtd = $bapMhs && $bapMhs->ttd_mahasiswa;
          @endphp
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $mhs->nama }}</td>
            <td>{{ $mhs->nim }}</td>
            <td>
              {{ $bapMhs ? ($bapMhs->hadir ? 'Hadir' : 'Tidak Hadir') : '-' }}
            </td>
            <td>
              @if ($sudahTtd)
                ✅
              @else
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="mt-4 text-end">
      <a href="{{ route('dosen.bap.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

  </div>
@endsection
