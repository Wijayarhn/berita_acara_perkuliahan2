@extends('layouts.admin.app')

@section('title', 'Tambah Jadwal')

@section('contents')
  <div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Jadwal</h1>

    <form action="{{ route('admin.jadwal.store') }}" method="POST">
      @csrf

      <div class="form-group">
        <label>Kode Mata Kuliah</label>
        <input type="text" name="kode_mk" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Nama Mata Kuliah</label>
        <input type="text" name="nama_mk" class="form-control" required>
      </div>

      <div class="form-group">
        <label>SKS</label>
        <input type="number" name="sks" class="form-control" required min="1">
      </div>

      <div class="form-group">
        <label>Nama Dosen</label>
        <select name="nama_dosen" class="form-control" required>
          <option value="">-- Pilih Dosen --</option>
          @foreach ($dosens as $dosen)
            <option value="{{ $dosen->nama }}">{{ $dosen->nama }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label>Kelas</label>
        <input type="text" name="kelas" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Jumlah Mahasiswa</label>
        <input type="number" name="jumlah_mhs" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Hari</label>
        <input type="text" name="hari" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Waktu (ex: 08:00 - 10:00)</label>
        <input type="text" name="waktu" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Ruang</label>
        <input type="text" name="ruang" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Kelompok</label>
        <input type="text" name="kelompok" class="form-control">
      </div>

      <div class="form-group">
        <label>Fakultas</label>
        <input type="text" name="fakultas" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Program Studi</label>
        <input type="text" name="prodi" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Tahun Ajaran</label>
        <input type="text" name="tahun_ajaran" class="form-control" placeholder="Contoh: 2024/2025" required>
      </div>

      <div class="form-group">
        <label>Semester</label>
        <input type="text" name="semester" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
@endsection
