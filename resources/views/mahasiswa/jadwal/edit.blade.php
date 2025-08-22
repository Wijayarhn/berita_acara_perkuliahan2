@extends('layouts.app')

@section('title', 'Edit Berita Acara Perkuliahan (BAP)')

@section('contents')
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h5>Edit Berita Acara Perkuliahan (BAP)</h5>
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
          <form action="{{ route('bap.update', $bap->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
              <label for="jadwal_id">Jadwal</label>
              <select name="jadwal_id" id="jadwal_id" class="form-control">
                <option value="">Pilih Jadwal</option>
                @foreach ($jadwals as $jadwal)
                  <option value="{{ $jadwal->id }}" {{ $bap->jadwal_id == $jadwal->id ? 'selected' : '' }}>
                    {{ $jadwal->mataKuliah->nama_mk }} ({{ $jadwal->hari }}, {{ $jadwal->jam_mulai }} -
                    {{ $jadwal->jam_selesai }})
                  </option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="tanggal">Tanggal</label>
              <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $bap->tanggal }}">
            </div>

            <div class="form-group">
              <label for="materi">Materi</label>
              <input type="text" name="materi" id="materi" class="form-control" value="{{ $bap->materi }}">
            </div>

            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <input type="text" name="keterangan" id="keterangan" class="form-control"
                value="{{ $bap->keterangan }}">
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('bap.index') }}" class="btn btn-secondary">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
