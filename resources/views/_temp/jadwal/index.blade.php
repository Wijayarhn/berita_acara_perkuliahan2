@extends('layouts.app')

@section('title', 'Jadwal Mengajar')

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
  <div class="container-fluid mt-4">
    <div class="card mb-4 shadow">
      <div class="card-header py-3">
        <h6 class="font-weight-bold text-primary m-0">📅 Jadwal Mengajar</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table-bordered table" id="dosenJadwalTable" width="100%" cellspacing="0">
            <thead>
              <tr class="text-center">
                <th>No</th>
                <th>Kode MK</th>
                <th>Mata Kuliah</th>
                <th>Kelas</th>
                <th>Hari</th>
                <th>Waktu</th>
                <th>Ruang</th>
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
      $('#dosenJadwalTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('dosen.jadwal.datatable') }}",
        order: [
          [4, 'asc'],
          [5, 'asc']
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
            data: 'ruang',
            name: 'ruang',
            className: 'text-center'
          },
          {
            data: 'aksi',
            name: 'aksi',
            orderable: false,
            searchable: false,
            className: 'text-center',
            width: '110px'
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
