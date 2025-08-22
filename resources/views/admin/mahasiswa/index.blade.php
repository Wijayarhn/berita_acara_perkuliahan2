@extends('layouts.admin.app')

@section('title', 'Data Mahasiswa')

@section('contents')
  <div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Mahasiswa</h1>

    <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary mb-3">Tambah Mahasiswa</a>

    <div class="table-responsive">
      <table class="table-bordered table-striped table">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIM</th>
            <th>Email</th>
            <th>Program Studi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($mahasiswas as $mahasiswa)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $mahasiswa->name }}</td>
              <td>{{ $mahasiswa->nim }}</td>
              <td>{{ $mahasiswa->email }}</td>
              <td>{{ $mahasiswa->prodi->nama ?? '-' }}</td>
              <td>
                <a href="{{ route('admin.mahasiswa.edit', $mahasiswa->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.mahasiswa.destroy', $mahasiswa->id) }}" method="POST"
                  style="display: inline-block;">
                  @csrf
                  @method('DELETE')
                  <button onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
