@extends('layouts.app')

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

    <h1 class="font-weight-bold mb-4 text-gray-800">📊 Dashboard Dosen</h1>

    <div class="row">
      <!-- Total Jadwal -->
      <div class="col-md-6 col-xl-3 mb-4">
        <div class="card border-left-primary h-100 hover-shadow py-2 shadow">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="font-weight-bold text-primary text-uppercase mb-1 text-xs">
                  <i class="fas fa-calendar-alt mr-1"></i> Total Jadwal
                </div>
                <div class="h5 font-weight-bold mb-0 text-gray-800">{{ $jumlahJadwal }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-calendar fa-2x text-primary"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Total BAP Dibuat -->
      <div class="col-md-6 col-xl-3 mb-4">
        <div class="card border-left-success h-100 hover-shadow py-2 shadow">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="font-weight-bold text-success text-uppercase mb-1 text-xs">
                  <i class="fas fa-file-signature mr-1"></i> Total BAP Dibuat
                </div>
                <div class="h5 font-weight-bold mb-0 text-gray-800">{{ $jumlahBap }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-check-circle fa-2x text-success"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Jadwal Belum Ada BAP -->
      <div class="col-md-6 col-xl-3 mb-4">
        <div class="card border-left-warning h-100 hover-shadow py-2 shadow">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="font-weight-bold text-warning text-uppercase mb-1 text-xs">
                  <i class="fas fa-exclamation-circle mr-1"></i> Belum Ada BAP
                </div>
                <div class="h5 font-weight-bold mb-0 text-gray-800">{{ $belumBuatBap }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-times-circle fa-2x text-warning"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Jadwal Hari Ini -->
      <div class="col-md-6 col-xl-3 mb-4">
        <div class="card border-left-info h-100 hover-shadow py-2 shadow">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="font-weight-bold text-info text-uppercase mb-1 text-xs">
                  <i class="fas fa-calendar-day mr-1"></i> Jadwal Hari Ini
                </div>
                <div class="h5 font-weight-bold mb-0 text-gray-800">{{ $jadwalHariIni }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-clock fa-2x text-info"></i>
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
    transform: translateY(-3px);
    transition: 0.3s ease-in-out;
  }
</style>
