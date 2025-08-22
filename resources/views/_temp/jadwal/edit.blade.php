@extends('layouts.app')

@section('title', 'Edit Jadwal Perkuliahan')

@section('contents')
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h5>Edit Jadwal Perkuliahan</h5>
        </div>
        <div class="card-body">
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="mata_kuliah_id">Mata Kuliah</label>
              <select name="mata_kuliah_id" id="mata_kuliah_id" class="form-control">
                @foreach ($mataKuliahs as $mataKuliah)
                  <option value="{{ $mataKuliah->id }}"
                    {{ $jadwal->mata_kuliah_id == $mataKuliah->id ? 'selected' : '' }}>
                    {{ $mataKuliah->nama_mk }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="kelas">Kelas</label>
              <input type="text" name="kelas" id="kelas" class="form-control" value="{{ $jadwal->kelas }}">
            </div>
            <div class="form-group">
              <label for="ruangan">Ruangan</label>
              <input type="text" name="ruangan" id="ruangan" class="form-control" value="{{ $jadwal->ruangan }}">
            </div>
            <div class="form-group">
              <label for="hari">Hari</label>
              <input type="text" name="hari" id="hari" class="form-control" value="{{ $jadwal->hari }}">
            </div>
            <div class="form-group">
              <label for="jam_mulai">Jam Mulai</label>
              <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="{{ $jadwal->jam_mulai }}">
            </div>
            <div class="form-group">
              <label for="jam_selesai">Jam Selesai</label>
              <input type="time" name="jam_selesai" id="jam_selesai" class="form-control"
                value="{{ $jadwal->jam_selesai }}">
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
