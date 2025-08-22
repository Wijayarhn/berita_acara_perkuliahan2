@extends('layouts.admin.app')

@section('title', 'Edit Dosen')

@section('contents')
  <div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Dosen</h1>

    <form action="{{ route('admin.dosen.update', $dosen->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" name="name" class="form-control" value="{{ $dosen->name }}" required>
      </div>

      <div class="form-group">
        <label>NIP</label>
        <input type="text" name="nip" class="form-control" value="{{ $dosen->nip }}" required>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ $dosen->email }}" required>
      </div>

      <div class="form-group">
        <label>Password (biarkan kosong jika tidak diganti)</label>
        <input type="password" name="password" class="form-control">
      </div>

      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
@endsection
