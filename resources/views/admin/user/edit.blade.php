@extends('layouts.admin.app')

@section('title', 'Edit User')

@section('contents')
  <div class="container">
    <h3>✏️ Edit Data User</h3>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('admin.user.update', [$tipe, $user->id]) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" name="nama" class="form-control" value="{{ old('nama', $user->nama) }}" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password Baru (Opsional)</label>
        <input type="password" name="password" class="form-control">
      </div>

      <div class="mb-3">
        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
        <input type="password" name="password_confirmation" class="form-control">
      </div>

      <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
      <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">← Batal</a>
    </form>
  </div>
@endsection
