@extends('layouts.admin.app')

@section('title', 'Tambah Dosen')

@section('contents')
  <div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Dosen</h1>

    <form action="{{ route('admin.dosen.store') }}" method="POST">
      @csrf

      <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" name="name" class="form-control" required>
      </div>

      <div class="form-group">
        <label>NIP</label>
        <input type="text" name="nip" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Password (default)</label>
        <input type="password" name="password" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
@endsection
