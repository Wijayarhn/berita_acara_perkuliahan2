@extends('layouts.admin.app')

@section('title', 'Edit Mahasiswa')

@section('contents')
  <div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Mahasiswa</h1>

    <form action="{{ route('admin.mahasiswa.update', $mahasiswa->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" name="name" class="form-control" value="{{ $mahasiswa->name }}" required>
      </div>

      <div class="form-group">
        <label>NIM</label>
        <input type="text" name="nim" class="form-control" value="{{ $mahasiswa->nim }}" required>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ $mahasiswa->email }}" required>
      </div>

      <div class="form-group">
        <label>Program Studi</label>
        <select name="prodi_id" class="form-control" required>
          <option value="">-- Pilih Prodi --</option>
          @foreach ($prodis as $prodi)
            <option value="{{ $prodi->id }}" {{ $mahasiswa->prodi_id == $prodi->id ? 'selected' : '' }}>
              {{ $prodi->nama }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label>Password (kosongkan jika tidak diubah)</label>
        <input type="password" name="password" class="form-control">
      </div>

      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
@endsection
