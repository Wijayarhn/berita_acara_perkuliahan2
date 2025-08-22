@extends('layouts.admin.app')

@section('title', 'Laporan Berita Acara Perkuliahan')

@section('contents')
  <div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Laporan BAP</h1>

    <div class="card mb-4 shadow">
      <div class="card-body">
        <form method="GET" action="{{ route('admin.laporan.bap') }}" class="form-inline mb-3">
          <div class="form-group mr-2">
            <label for="tanggal" class="mr-2">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ request('tanggal') }}">
          </div>
          <button type="submit" class="btn btn-primary">Filter</button>
          <a href="{{ route('admin.laporan.bap') }}" class="btn btn-secondary ml-2">Reset</a>
        </form>

        <div class="table-responsive">
          <table class="table-bordered table-hover table">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Dosen</th>
                <th>Matkul</th>
                <th>Tanggal</th>
                <th>Materi</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($baps as $bap)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $bap->dosen->nama ?? '-' }}</td>
                  <td>{{ $bap->jadwal->matkul ?? '-' }}</td>
                  <td>{{ $bap->tanggal }}</td>
                  <td>{{ $bap->materi }}</td>
                  <td>
                    @if ($bap->status == 'disetujui')
                      <span class="badge badge-success">Disetujui</span>
                    @elseif ($bap->status == 'ditolak')
                      <span class="badge badge-danger">Ditolak</span>
                    @else
                      <span class="badge badge-secondary">Menunggu</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
