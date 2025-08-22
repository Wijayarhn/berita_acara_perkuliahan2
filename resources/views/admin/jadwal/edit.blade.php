@extends('layouts.admin.app')

@section('title', 'Edit Jadwal')

@section('contents')
  <div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Jadwal</h1>

    <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label>Kode Mata Kuliah</label>
        <input type="text" name="kode_mk" class="form-control" value="{{ $jadwal->kode_mk }}" required>
      </div>

      <div class="form-group">
        <label>Nama Mata Kuliah</label>
        <input type="text" name="nama_mk" class="form-control" value="{{ $jadwal->nama_mk }}" required>
      </div>

      <div class="form-group">
        <label>SKS</label>
        <input type="number" name="sks" class="form-control" value="{{ $jadwal->sks }}" required min="1">
      </div>

      <div class="form-group">
        <label>Nama Dosen</label>
        <select name="nama_dosen" class="form-control" required>
          <option value="">-- Pilih Dosen --</option>
          @foreach ($dosens as $dosen)
            <option value="{{ $dosen->nama }}" {{ $jadwal->nama_dosen == $dosen->nama ? 'selected' : '' }}>
              {{ $dosen->nama }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label>Kelas</label>
        <input type="text" name="kelas" class="form-control" value="{{ $jadwal->kelas }}" required>
      </div>

      <div class="form-group">
        <label>Jumlah Mahasiswa</label>
        <input type="number" name="jumlah_mhs" class="form-control" value="{{ $jadwal->jumlah_mhs }}" required>
      </div>

      <div class="form-group">
        <label>Hari</label>
        <input type="text" name="hari" class="form-control" value="{{ $jadwal->hari }}" required>
      </div>

      <div class="form-group">
        <label>Waktu (ex: 08:00 - 10:00)</label>
        <input type="text" name="waktu" class="form-control" value="{{ $jadwal->waktu }}" required>
      </div>

      <div class="form-group">
        <label>Ruang</label>
        <input type="text" name="ruang" class="form-control" value="{{ $jadwal->ruang }}" required>
      </div>

      <div class="form-group">
        <label>Kelompok</label>
        <input type="text" name="kelompok" class="form-control" value="{{ $jadwal->kelompok }}">
      </div>

      <div class="form-group">
        <label>Fakultas</label>
        <input type="text" name="fakultas" class="form-control" value="{{ $jadwal->fakultas }}" required>
      </div>

      <div class="form-group">
        <label>Program Studi</label>
        <input type="text" name="prodi" class="form-control" value="{{ $jadwal->prodi }}" required>
      </div>

      <div class="form-group">
        <label>Tahun Ajaran</label>
        <input type="text" name="tahun_ajaran" class="form-control" value="{{ $jadwal->tahun_ajaran }}" required>
      </div>

      <div class="form-group">
        <label>Semester</label>
        <input type="text" name="semester" class="form-control" value="{{ $jadwal->semester }}" required>
      </div>

      <button type="submit" class="btn btn-primary">Update</button>
      <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
@endsection
