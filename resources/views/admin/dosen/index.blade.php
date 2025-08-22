@extends('layouts.admin')

@section('content')
  <h3>📊 Laporan BAP per Dosen</h3>
  <table class="table">
    <thead>
      <tr>
        <th>Nama Dosen</th>
        <th>Jumlah BAP</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($dosens as $dosen)
        <tr>
          <td>{{ $dosen->nama }}</td>
          <td>{{ $dosen->bap_count }}</td>
          <td>
            <a href="{{ route('admin.reports.dosen.show', $dosen->id) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
