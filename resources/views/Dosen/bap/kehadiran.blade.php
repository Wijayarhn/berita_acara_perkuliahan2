@extends('layouts.dosen.app')
@section('title', 'Kehadiran Mahasiswa')

@section('contents')
  <div class="container">
    <h4 class="mb-4">Daftar Kehadiran Mahasiswa</h4>

    <table class="table-striped table">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama</th>
          <th>NIM</th>
          <th>Status Kehadiran</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($kehadiran as $item)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->mahasiswa->nama }}</td>
            <td>{{ $item->mahasiswa->nim }}</td>
            <td>{{ $item->status }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
