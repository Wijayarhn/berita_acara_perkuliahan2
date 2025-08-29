@extends('layouts.admin.app')

@section('title', 'Tambah User')

@push('styles')
  {{-- CSS Select2 --}}
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    /* Biar Select2 menyesuaikan dengan form bootstrap */
    .select2-container .select2-selection--single {
      height: 40px;
      border: 1px solid #ced4da;
      border-radius: 6px;
      padding: 5px 10px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: 28px;
      color: #000;
      /* teks pilihan hitam */
    }

    .select2-container--default .select2-selection--single .select2-selection__placeholder {
      color: #888;
      /* placeholder abu-abu */
      font-style: italic;
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
      <div class="form-group mb-3">
        <label for="roleSelect">Role</label>
        <select name="role" id="roleSelect" class="form-control" required>
          <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- Pilih Role --</option>
          <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
          <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
        </select>
      </div>

      {{-- Nama --}}
      <div class="form-group mb-3">
        <input name="nama" type="text" class="form-control" placeholder="Nama Lengkap" value="{{ old('nama') }}"
          required>
      </div>

      {{-- Username --}}
      <div class="form-group mb-3">
        <input name="username" type="text" class="form-control" placeholder="Username" value="{{ old('username') }}"
          required>
      </div>

      {{-- NIDN (khusus dosen) --}}
      <div class="form-group role-dosen mb-3" style="display:none;">
        <input name="nidn" type="text" class="form-control" placeholder="NIDN (khusus dosen)"
          value="{{ old('nidn') }}">
      </div>

      {{-- NIM (khusus mahasiswa) --}}
      <div class="form-group role-mahasiswa mb-3" style="display:none;">
        <input name="nim" type="text" class="form-control" placeholder="NIM (khusus mahasiswa)"
          value="{{ old('nim') }}">
      </div>

      {{-- Kelas (khusus mahasiswa) --}}
      <div class="form-group role-mahasiswa mb-3" style="display:none;">
        <input name="kelas" type="text" class="form-control" placeholder="Kelas (khusus mahasiswa)"
          value="{{ old('kelas') }}">
      </div>

      {{-- Password --}}
      <div class="form-group row">
        <div class="col-sm-6 mb-sm-0 mb-3">
          <input name="password" type="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="col-sm-6">
          <input name="password_confirmation" type="password" class="form-control" placeholder="Ulangi Password" required>
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
  {{-- JS Select2 --}}
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

    $(document).ready(function() {
      // aktifkan Select2
      $('#roleSelect').select2({
        placeholder: "-- Pilih Role --",
        allowClear: true,
        width: '100%'
      });

      // toggle form sesuai role saat pertama load + saat ganti
      toggleRoleFields();
      $('#roleSelect').on('change', toggleRoleFields);
    });
  </script>
@endpush
