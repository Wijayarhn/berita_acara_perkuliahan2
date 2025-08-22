@extends('layouts.admin.app')

@section('title', 'Manajemen User')

@section('contents')
  <div class="container-fluid">
    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
      <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i> Tambah User
      </a>
    </div>

    {{-- Switcher Role --}}
    @php
      $active = $type ?? 'admin';
      function btnUrl($t)
      {
          return route('admin.user.index', ['type' => $t]);
      }
    @endphp

    <div class="btn-group mb-4" role="group" aria-label="Pilih Role">
      <a href="{{ btnUrl('admin') }}" class="btn {{ $active === 'admin' ? 'btn-primary' : 'btn-outline-primary' }}">
        <i class="fas fa-user-shield mr-1"></i> Admin
      </a>
      <a href="{{ btnUrl('dosen') }}" class="btn {{ $active === 'dosen' ? 'btn-success' : 'btn-outline-success' }}">
        <i class="fas fa-chalkboard-teacher mr-1"></i> Dosen
      </a>
      <a href="{{ btnUrl('mahasiswa') }}"
        class="btn {{ $active === 'mahasiswa' ? 'btn-warning' : 'btn-outline-warning' }}">
        <i class="fas fa-user-graduate mr-1"></i> Mahasiswa
      </a>
    </div>

    {{-- Tabel sesuai role terpilih --}}
    <div class="card shadow-sm">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span class="font-weight-bold">{{ $title }}</span>
        {{-- (opsional) tempat search/filter per role --}}
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table-hover mb-0 table">
            <thead class="thead-light">
              <tr>
                @foreach ($columns as $label)
                  <th>{{ $label }}</th>
                @endforeach
                <th style="width:200px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($rows as $row)
                <tr>
                  @foreach (array_keys($columns) as $col)
                    <td>{{ $row->$col }}</td>
                  @endforeach
                  <td>
                    <a href="{{ route('admin.user.show', [$active, $row->id]) }}" class="btn btn-info btn-sm"
                      title="Lihat">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.user.edit', [$active, $row->id]) }}" class="btn btn-warning btn-sm"
                      title="Edit">
                      <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.user.destroy', [$active, $row->id]) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                      @csrf @method('DELETE')
                      <button class="btn btn-danger btn-sm" title="Hapus">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="{{ count($columns) + 1 }}" class="text-muted text-center">Data tidak tersedia.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer">
        {{ $rows->withQueryString()->links() }}
      </div>
    </div>
  </div>
@endsection
