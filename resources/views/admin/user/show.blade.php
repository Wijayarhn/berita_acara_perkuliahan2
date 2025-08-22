@extends('layouts.admin.app')

@section('title', 'Lihat Data User')

@section('contents')
  <div class="container">
    <h3>👤 Detail User</h3>

    <div class="card mt-3 p-4">
      <p><strong>Role:</strong> {{ ucfirst($tipe) }}</p>
      <p><strong>Nama:</strong> {{ $user->nama }}</p>

      @if ($tipe == 'dosen')
        <p><strong>NIDN:</strong> {{ $user->nidn ?? '-' }}</p>
      @elseif ($tipe == 'mahasiswa')
        <p><strong>NIM:</strong> {{ $user->nim ?? '-' }}</p>
      @endif
    </div>

    <div class="mt-4">
      <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>
  </div>
@endsection
