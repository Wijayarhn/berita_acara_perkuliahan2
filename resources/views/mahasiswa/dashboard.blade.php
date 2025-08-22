@extends('layouts.mahasiswa.app')

@section('title', 'Dashboard Mahasiswa')

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

    <h1 class="font-weight-bold mb-4 text-gray-800">📑 Dashboard Mahasiswa</h1>

    <div class="row">
      <!-- Total BAP -->
      <div class="col-md-3 mb-4">
        <div class="card border-left-primary h-100 hover-shadow py-2 shadow">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col mr-2">
                <div class="font-weight-bold text-primary text-uppercase mb-1 text-xs">
                  <i class="fas fa-file-alt mr-1"></i> Total BAP
                </div>
                <div class="h5 font-weight-bold mb-0 text-gray-800">{{ $totalBap }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-file fa-2x text-primary"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Sudah TTD -->
      <div class="col-md-3 mb-4">
        <div class="card border-left-success h-100 hover-shadow py-2 shadow">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col mr-2">
                <div class="font-weight-bold text-success text-uppercase mb-1 text-xs">
                  <i class="fas fa-pen-nib mr-1"></i> Sudah TTD
                </div>
                <div class="h5 font-weight-bold mb-0 text-gray-800">{{ $sudahTtd }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-check fa-2x text-success"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Belum TTD -->
      <div class="col-md-3 mb-4">
        <div class="card border-left-danger h-100 hover-shadow py-2 shadow">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col mr-2">
                <div class="font-weight-bold text-danger text-uppercase mb-1 text-xs">
                  <i class="fas fa-times-circle mr-1"></i> Belum TTD
                </div>
                <div class="h5 font-weight-bold mb-0 text-gray-800">{{ $belumTtd }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-exclamation fa-2x text-danger"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- BAP Hari Ini -->
      <div class="col-md-3 mb-4">
        <div class="card border-left-info h-100 hover-shadow py-2 shadow">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col mr-2">
                <div class="font-weight-bold text-info text-uppercase mb-1 text-xs">
                  <i class="fas fa-calendar-day mr-1"></i> BAP Hari Ini
                </div>
                <div class="h5 font-weight-bold mb-0 text-gray-800">{{ $bapHariIni }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-calendar fa-2x text-info"></i>
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
