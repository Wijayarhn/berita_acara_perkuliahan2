@extends('layouts.admin.app')

@section('title', 'Upload Jadwal Kuliah')

@section('contents')
  <div class="container">
    <h1 class="my-4">Upload Jadwal Kuliah (Excel)</h1>

    {{-- Notifikasi sukses --}}
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
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

    <form action="{{ route('admin.jadwal.import') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="form-group mb-3">
        <label for="file">Pilih File Excel (.xlsx / .xls)</label>
        <input type="file" name="file" id="file" class="form-control" required accept=".xls,.xlsx">
      </div>

      <button type="submit" class="btn btn-success">Upload</button>
      <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">Kembali</a>
    </form>

    <hr class="my-4">

    <h5>📄 Format Excel yang Didukung:</h5>
    <ul>
      <li><strong>NO</strong></li>
      <li><strong>KODE MK</strong></li>
      <li><strong>MATA KULIAH</strong></li>
      <li><strong>SKS</strong></li>
      <li><strong>DOSEN</strong></li>
      <li><strong>KELAS</strong></li>
      <li><strong>MHS</strong></li>
      <li><strong>HARI</strong></li>
      <li><strong>WAKTU</strong> (contoh: 07.30 - 09.10)</li>
      <li><strong>RUANG</strong></li>
      <li><strong>KELOMPOK</strong></li>
      <li><strong>PRODI</strong> (contoh: FILKOM/Ilmu Komputer)</li>
    </ul>

  </div>
@endsection
