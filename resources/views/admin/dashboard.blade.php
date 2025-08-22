@extends('layouts.admin.app')

@section('contents')
  <div class="container-fluid">
    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif

    <h1 class="font-weight-bold mb-4 text-gray-800">📋 Dashboard Admin</h1>

    <div class="row">
      <!-- Total Dosen -->
      <div class="col-md-4 mb-4">
        <div class="card border-left-primary h-100 hover-shadow py-2 shadow">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col mr-2">
                <div class="font-weight-bold text-primary text-uppercase mb-1 text-xs">
                  <i class="fas fa-chalkboard-teacher mr-1"></i> Total Dosen
                </div>
                <div class="h5 font-weight-bold mb-0 text-gray-800">{{ $dosenCount }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-user-tie fa-2x text-primary"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Total Mahasiswa -->
      <div class="col-md-4 mb-4">
        <div class="card border-left-success h-100 hover-shadow py-2 shadow">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col mr-2">
                <div class="font-weight-bold text-success text-uppercase mb-1 text-xs">
                  <i class="fas fa-user-graduate mr-1"></i> Total Mahasiswa
                </div>
                <div class="h5 font-weight-bold mb-0 text-gray-800">{{ $mahasiswaCount }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-users fa-2x text-success"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Total Jadwal -->
      <div class="col-md-4 mb-4">
        <div class="card border-left-warning h-100 hover-shadow py-2 shadow">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col mr-2">
                <div class="font-weight-bold text-warning text-uppercase mb-1 text-xs">
                  <i class="fas fa-calendar-alt mr-1"></i> Total Jadwal Kuliah
                </div>
                <div class="h5 font-weight-bold mb-0 text-gray-800">{{ $jadwalCount }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-calendar-check fa-2x text-warning"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

<style>
  .hover-shadow:hover {
    transform: translateY(-4px);
    transition: 0.3s ease;
  }
</style>
