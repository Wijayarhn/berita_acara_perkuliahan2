@extends('layouts.admin.app')

@section('title', 'Tambah Mahasiswa')

@section('contents')
  <div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Mahasiswa</h1>

    <form action="{{ route('admin.mahasiswa.store') }}" method="POST">
      @csrf

      <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" name="name" class="form-control" required>
      </div>

      <div class="form-group">
        <label>NIM</label>
        <input type="text" name="nim" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Program Studi</label>
        <select name="prodi_id" class="form-control" required>
          <option value="">-- Pilih Prodi --</option>
          @foreach ($prodis as $prodi)
            <option value="{{ $prodi->id }}">{{ $prodi->nama }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
@endsection
