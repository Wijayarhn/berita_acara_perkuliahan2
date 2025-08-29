@extends('layouts.admin.app')

@section('title', 'Tambah User')

@push('styles')
  <style>
    /* Biar teks di select terlihat jelas */
    select.form-control-user {
      color: #000 !important;
      background-color: #fff !important;
      /* pastikan background putih */
    }

    /* Warna teks default option (placeholder) */
    select.form-control-user option[disabled],
    select.form-control-user option[value=""] {
      color: #888 !important;
      font-style: italic;
    }

    /* Pastikan option lain tetap hitam */
    select.form-control-user option {
      color: #000 !important;
    }

    /* Cadangan label tampilan role */
    #roleSelected {
      margin-top: 5px;
      font-size: 0.9rem;
      color: #555;
    }
  </style>
@endpush

@section('contents')
  <div class="container-fluid mt-4">
    <h3 class="mb-4">Tambah User</h3>

    {{-- Notifikasi sukses --}}
    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Notifikasi error --}}
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
        <label for="roleSelect">Role</label>
        <select name="role" id="roleSelect" class="form-control form-control-user" required>
          <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- Pilih Role --</option>
          <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
          <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
        </select>

        {{-- Fallback indikator pilihan --}}
        <small id="roleSelected"></small>
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
      <div class="form-group role-dosen" style="display:none;">
        <input name="nidn" type="text" class="form-control form-control-user" placeholder="NIDN (khusus dosen)"
          value="{{ old('nidn') }}">
      </div>

      {{-- NIM (khusus mahasiswa) --}}
      <div class="form-group role-mahasiswa" style="display:none;">
        <input name="nim" type="text" class="form-control form-control-user" placeholder="NIM (khusus mahasiswa)"
          value="{{ old('nim') }}">
      </div>

      {{-- Kelas (khusus mahasiswa) --}}
      <div class="form-group role-mahasiswa" style="display:none;">
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

@push('scripts')
  <script>
    function toggleRoleFields() {
      const role = document.getElementById('roleSelect').value;

      // sembunyikan semua field dulu
      document.querySelectorAll('.role-dosen, .role-mahasiswa').forEach(el => el.style.display = 'none');

      if (role === 'dosen') {
        document.querySelectorAll('.role-dosen').forEach(el => el.style.display = 'block');
      } else if (role === 'mahasiswa') {
        document.querySelectorAll('.role-mahasiswa').forEach(el => el.style.display = 'block');
      }
    }

    function showSelectedRole() {
      const role = document.getElementById('roleSelect').value;
      const label = document.getElementById('roleSelected');

      if (role === 'admin') {
        label.innerText = "Anda memilih: Admin";
      } else if (role === 'dosen') {
        label.innerText = "Anda memilih: Dosen";
      } else if (role === 'mahasiswa') {
        label.innerText = "Anda memilih: Mahasiswa";
      } else {
        label.innerText = "";
      }
    }

    document.getElementById('roleSelect').addEventListener('change', function() {
      toggleRoleFields();
      showSelectedRole();
    });

    // jalankan saat halaman load supaya old('role') tetap tampil
    window.addEventListener('DOMContentLoaded', function() {
      toggleRoleFields();
      showSelectedRole();
    });
  </script>
@endpush
