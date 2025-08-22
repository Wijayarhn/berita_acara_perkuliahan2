@extends('layouts.app')

@section('title', 'Manajemen BAP')

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
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="mb-0">📄 Berita Acara Perkuliahan</h3>
      <a href="{{ route('dosen.bap.create') }}" class="btn btn-primary">+ Buat BAP</a>
    </div>

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table-bordered table" id="bapDosenTable" width="100%" cellspacing="0">
            <thead>
              <tr class="text-center">
                <th>#</th>
                <th>Mata Kuliah</th>
                <th>Tanggal</th>
                <th>Pertemuan</th>
                <th>Status</th>
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
      $('#bapDosenTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('dosen.bap.datatable') }}",
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
            data: 'pertemuan_ke',
            name: 'pertemuan_ke',
            className: 'text-center',
            width: '110px'
          },
          {
            data: 'status_text',
            name: 'status',
            className: 'text-center',
            width: '120px'
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
