@extends('layouts.mahasiswa.app')

@section('title', '🧾 Daftar BAP Aktif')

@push('styles')
  <link href="{{ asset('admin_assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css" rel="stylesheet">
  <style>
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
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="table-responsive">
          <table id="bapAktifTable" class="table-bordered table" width="100%" cellspacing="0">
            <thead>
              <tr class="text-center">
                <th>#</th>
                <th>Mata Kuliah</th>
                <th>Tanggal</th>
                <th>Materi</th>
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
      $('#bapAktifTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('mahasiswa.bap.datatable') }}",
        order: [
          [2, 'desc']
        ], // Tanggal
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            className: 'text-center',
            width: '50px'
          },
          {
            data: 'mata_kuliah',
            name: 'mata_kuliah'
          },
          {
            data: 'tanggal',
            name: 'tanggal',
            className: 'text-center',
            width: '120px'
          },
          {
            data: 'materi',
            name: 'materi'
          },
          {
            data: 'aksi',
            orderable: false,
            searchable: false,
            className: 'text-center',
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
