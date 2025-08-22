@extends('layouts.admin.app')

@section('contents')
  <h3>📄 Detail BAP - {{ $dosen->nama }}</h3>
  <table class="table">
    <thead>
      <tr>
        <th>Mata Kuliah</th>
        <th>Tanggal</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($dosen->bap as $bap)
        <tr>
          <td>{{ $bap->jadwal->nama_mk ?? '-' }}</td>
          <td>{{ $bap->tanggal }}</td>
          <td>{{ ucfirst($bap->status_verifikasi) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
