@extends('layouts.admin.app')

@section('contents')
  <h3>📑 Laporan Semua BAP</h3>
  <a href="{{ route('admin.reports.bap.export') }}" class="btn btn-success mb-3">⬇️ Export PDF</a>
  <table class="table">
    <thead>
      <tr>
        <th>Dosen</th>
        <th>Matkul</th>
        <th>Tanggal</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($baps as $bap)
        <tr>
          <td>{{ $bap->dosen->nama }}</td>
          <td>{{ $bap->jadwal->nama_mk }}</td>
          <td>{{ $bap->tanggal }}</td>
          <td>{{ ucfirst($bap->status_verifikasi) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
