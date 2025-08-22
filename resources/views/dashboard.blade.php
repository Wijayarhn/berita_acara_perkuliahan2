@extends('layouts.mahasiswa.app')
@section('title', 'Dashboard Mahasiswa')

@section('contents')
  <div class="container">
    <h4>Selamat Datang, {{ auth()->user()->name }}</h4>
    <p>Silakan cek dan tandatangani Berita Acara Perkuliahan yang aktif.</p>

    <a href="{{ route('mahasiswa.bap.aktif') }}" class="btn btn-primary mt-3">Lihat BAP Aktif</a>
  </div>
@endsection
