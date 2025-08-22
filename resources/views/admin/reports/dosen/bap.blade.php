@extends('layouts.admin.app')

@section('contents')
  <div class="container-fluid">
    <h1 class="mb-4">Berita Acara - {{ $jadwal->nama_mk }} ({{ $dosen->nama }})</h1>

    <a href="{{ route('admin.reports.jadwal', $dosen->id) }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>
    <a href="{{ route('admin.reports.export', [$dosen->id, $jadwal->id]) }}" class="btn btn-sm btn-danger mb-3">
      Export PDF
    </a>

    <div class="card shadow">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table-bordered table-striped table">
            <thead>
              <tr>
                <th>Pertemuan</th>
                <th>Tanggal</th>
                <th>Materi</th>
                <th>Lokasi</th>
                <th>Mahasiswa Hadir</th>
                <th>Dokumentasi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($baps as $bap)
                <tr>
                  <td>{{ $bap->pertemuan }}</td>
                  <td>{{ $bap->tanggal }}</td>
                  <td>{{ $bap->materi }}</td>
                  <td>{{ $bap->lokasi }}</td>
                  <td>{{ $bap->mahasiswa_hadir }}</td>
                  <td>
                    @if ($bap->dokumentasi)
                      <a href="{{ asset('storage/' . $bap->dokumentasi) }}" target="_blank">Lihat</a>
                    @else
                      Tidak ada
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center">Tidak ada BAP ditemukan.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="mt-3">
          {{ $baps->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection
