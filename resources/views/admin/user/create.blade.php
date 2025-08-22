@extends('layouts.admin.app')

@section('title', 'Tambah User')

@section('contents')
  <div class="container-fluid mt-4">
    <h3 class="mb-4">Tambah User</h3>

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('admin.user.store') }}" method="POST" class="user">
      @csrf

      {{-- Role --}}
      <div class="form-group">
        <select name="role" class="form-control form-control-user" required>
          <option value="">-- Pilih Role --</option>
          <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
          <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
        </select>
      </div>

      {{-- Nama --}}
      <div class="form-group">
        <input name="nama" type="text" class="form-control form-control-user" placeholder="Nama Lengkap"
          value="{{ old('nama') }}" required>
      </div>

      {{-- Username --}}
      <div class="form-group">
        <input name="username" type="text" class="form-control form-control-user" placeholder="Username"
          value="{{ old('username') }}" required>
      </div>

      {{-- NIDN (khusus dosen) --}}
      <div class="form-group">
        <input name="nidn" type="text" class="form-control form-control-user" placeholder="NIDN (khusus dosen)"
          value="{{ old('nidn') }}">
      </div>

      {{-- NIM (khusus mahasiswa) --}}
      <div class="form-group">
        <input name="nim" type="text" class="form-control form-control-user" placeholder="NIM (khusus mahasiswa)"
          value="{{ old('nim') }}">
      </div>

      {{-- Kelas (khusus mahasiswa) --}}
      <div class="form-group">
        <input name="kelas" type="text" class="form-control form-control-user" placeholder="Kelas (khusus mahasiswa)"
          value="{{ old('kelas') }}">
      </div>

      {{-- Password --}}
      <div class="form-group row">
        <div class="col-sm-6 mb-sm-0 mb-3">
          <input name="password" type="password" class="form-control form-control-user" placeholder="Password" required>
        </div>
        <div class="col-sm-6">
          <input name="password_confirmation" type="password" class="form-control form-control-user"
            placeholder="Ulangi Password" required>
        </div>
      </div>

      {{-- Tombol --}}
      <div class="form-group d-flex justify-content-between mt-4">
        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
@endsection
