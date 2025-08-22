@extends('layouts.app')

@section('title', 'Tambah Berita Acara Perkuliahan (BAP)')

@section('contents')
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h5>Tambah Berita Acara Perkuliahan (BAP)</h5>
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
          <form action="{{ route('bap.store') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="jadwal_id">Jadwal</label>
              <select name="jadwal_id" id="jadwal_id" class="form-control">
                <option value="">Pilih Jadwal</option>
                @foreach ($jadwals as $jadwal)
                  <option value="{{ $jadwal->id }}">
                    {{ $jadwal->mataKuliah->nama_mk }} ({{ $jadwal->hari }}, {{ $jadwal->jam_mulai }} -
                    {{ $jadwal->jam_selesai }})
                  </option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="tanggal">Tanggal</label>
              <input type="date" name="tanggal" id="tanggal" class="form-control">
            </div>

            <div class="form-group">
              <label for="materi">Materi</label>
              <input type="text" name="materi" id="materi" class="form-control">
            </div>

            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <input type="text" name="keterangan" id="keterangan" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('bap.index') }}" class="btn btn-secondary">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
