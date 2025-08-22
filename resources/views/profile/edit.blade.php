{{-- Gunakan layout berdasarkan role --}}
@if (auth()->user()->role === 'dosen')
  @extends('layouts.dosen.app')
@elseif (auth()->user()->role === 'mahasiswa')
  @extends('layouts.mahasiswa.app')
@endif

@section('title', 'Edit Profil')

@section('contents')
  <div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Profil</h1>

    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <form action="{{ route(auth()->user()->role . '.profile.update') }}" method="POST">
      @csrf

      <div class="form-group">
        <label for="name">Nama</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
      </div>

      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" class="form-control" value="{{ old('username', auth()->user()->username) }}"
          required>
      </div>

      <div class="form-group">
        <label for="password">Password (kosongkan jika tidak ingin mengubah)</label>
        <input type="password" name="password" class="form-control">
      </div>

      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
  </div>
@endsection
