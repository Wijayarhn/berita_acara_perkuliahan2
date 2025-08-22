@extends('layouts.admin.app')

@section('title', 'Daftar Verifikasi BAP')

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
        <h6 class="font-weight-bold text-primary m-0">Daftar Verifikasi BAP</h6>
        {{-- kalau mau tombol lain, taruh di sini --}}
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table-bordered primary table" id="bapTable" width="100%" cellspacing="0">
            <thead class="bg-primary">
              <tr class="text-center text-white">
                <th>No</th>
                <th>Hari</th>
                <th>Mata Kuliah</th>
                <th>Dosen</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Dibuat</th>
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
      $('#bapTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.bap.datatable') }}", // pastikan route ini diletakkan sebelum /bap/{id}
        order: [
          [6, 'desc']
        ], // kolom 'Dibuat'
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            data: 'hari',
            name: 'hari'
          },
          {
            data: 'mata_kuliah',
            name: 'mata_kuliah'
          },
          {
            data: 'dosen_nama',
            name: 'dosen_nama'
          },
          {
            data: 'waktu',
            name: 'waktu'
          },
          {
            data: 'status',
            name: 'status'
          },
          {
            data: 'created_at',
            name: 'created_at'
          },
          {
            data: 'aksi',
            name: 'aksi',
            orderable: false,
            searchable: false
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
