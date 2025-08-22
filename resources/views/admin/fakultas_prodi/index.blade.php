@extends('layouts.admin.app')

@section('title', 'Fakultas & Program Studi')

@section('contents')
  <div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Manajemen Fakultas & Program Studi</h1>

    <div class="row">
      <!-- Form Tambah Prodi -->
      <div class="col-md-4">
        <div class="card mb-4 shadow">
          <div class="card-header py-3">
            <h6 class="font-weight-bold text-primary m-0">Tambah Prodi</h6>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.fakultas_prodi.store') }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="fakultas">Fakultas</label>
                <input type="text" name="fakultas" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="prodi">Program Studi</label>
                <input type="text" name="prodi" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Simpan</button>
            </form>
          </div>
        </div>
      </div>

      <!-- Tabel List Prodi -->
      <div class="col-md-8">
        <div class="card mb-4 shadow">
          <div class="card-header py-3">
            <h6 class="font-weight-bold text-primary m-0">Daftar Prodi</h6>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table-bordered table-hover table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Fakultas</th>
                    <th>Program Studi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($prodis as $prodi)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $prodi->fakultas }}</td>
                      <td>{{ $prodi->nama }}</td>
                    </tr>
                  @endforeach
                  @if ($prodis->isEmpty())
                    <tr>
                      <td colspan="3" class="text-center">Belum ada data</td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
