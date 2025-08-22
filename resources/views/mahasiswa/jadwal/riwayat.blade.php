@extends('layouts.mahasiswa.app')
@section('title', 'Riwayat Tanda Tangan BAP')

@section('contents')
  <div class="container-fluid">

    <table class="table-bordered table">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Mata Kuliah</th>
          <th>Tanggal</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($riwayat as $ttd)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $ttd->bap->jadwal->matakuliah }}</td>
            <td>{{ $ttd->bap->tanggal }}</td>
            <td>{{ ucfirst($ttd->status) }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="text-center">Belum ada riwayat tanda tangan.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
