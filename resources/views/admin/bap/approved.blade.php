@extends('layouts.admin.app')

@section('title', 'BAP yang Sudah Disetujui')

@section('contents')
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h5>BAP yang Sudah Diapprove</h5>
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Mata Kuliah</th>
                <th>Materi</th>
                <th>Keterangan</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($baps as $bap)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $bap->tanggal }}</td>
                  <td>{{ $bap->jadwal->mataKuliah->nama_mk }}</td>
                  <td>{{ $bap->materi }}</td>
                  <td>{{ $bap->keterangan }}</td>
                  <td><span class="badge badge-success">{{ ucfirst($bap->status) }}</span></td>
                  <td><a href="{{ route('admin.bap.show', $bap->id) }}" class="btn btn-info btn-sm">Detail</a></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
