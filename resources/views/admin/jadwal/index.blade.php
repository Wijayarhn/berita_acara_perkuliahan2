@extends('layouts.admin.app')

@section('title', 'Manajemen Jadwal')

@push('styles')
  <link href="{{ asset('admin_assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css" rel="stylesheet">
  <style>
    /* polos: semua teks hitam */
    table.dataTable td,
    table.dataTable th,
    .form-control,
    .form-control:focus,
    .form-label,
    label {
      color: #000 !important;
    }
  </style>
@endpush

@section('contents')
  <div class="container-fluid">
    <div class="card mb-4 shadow">
      <div class="card-header d-flex justify-content-between align-items-center py-3">
        <h6 class="font-weight-bold text-primary m-0">Manajemen Jadwal</h6>
        <div class="d-flex gap-2">
          <a href="{{ route('admin.jadwal.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Jadwal
          </a>
          <a href="{{ route('admin.jadwal.import.form') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-upload fa-sm text-white-50"></i> Upload Jadwal (Excel)
          </a>
        </div>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table-bordered table" id="jadwalTable" width="100%" cellspacing="0">
            <thead>
              <tr class="text-center">
                <th>No</th>
                <th>Kode MK</th>
                <th>Mata Kuliah</th>
                <th>Dosen</th>
                <th>Kelas</th>
                <th>Hari</th>
                <th>Waktu</th>
                <th>Aksi</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('admin_assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('admin_assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script>
    $(function() {
      $('#jadwalTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.jadwal.datatable') }}",
        order: [
          [5, 'asc'],
          [6, 'asc']
        ], // Hari, Waktu
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            className: 'text-center',
            width: '50px'
          },
          {
            data: 'kode_mk',
            name: 'kode_mk'
          },
          {
            data: 'nama_mk',
            name: 'nama_mk'
          },
          {
            data: 'nama_dosen',
            name: 'nama_dosen'
          },
          {
            data: 'kelas',
            name: 'kelas',
            className: 'text-center'
          },
          {
            data: 'hari',
            name: 'hari',
            className: 'text-center'
          },
          {
            data: 'waktu',
            name: 'waktu',
            className: 'text-center'
          },
          {
            data: 'aksi',
            name: 'aksi',
            className: 'text-center',
            orderable: false,
            searchable: false,
            width: '140px'
          },
        ],
        dom: 'Blfrtip',
        buttons: ['copy', 'excel', 'pdf'],
        pageLength: 10,
        lengthMenu: [
          [10, 20, 50, 100],
          [10, 20, 50, 100]
        ]
      });
    });
  </script>
@endpush
