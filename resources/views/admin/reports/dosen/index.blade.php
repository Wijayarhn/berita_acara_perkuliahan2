@extends('layouts.admin.app')

@section('title', 'Laporan BAP per Dosen')

@push('styles')
  <link href="{{ asset('admin_assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css" rel="stylesheet">
  <style>
    /* polos: teks hitam */
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
    <div class="card mb-4 shadow-sm">
      <div class="card-header d-flex justify-content-between align-items-center py-3">
        <h6 class="font-weight-bold text-primary m-0">
          <i class="fas fa-chalkboard-teacher mr-2"></i> Laporan BAP per Dosen
        </h6>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table-bordered table" id="dosenTable" width="100%" cellspacing="0">
            <thead>
              <tr class="text-center">
                <th>No</th>
                <th>Nama Dosen</th>
                <th>Jumlah BAP Dibuat</th>
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
      $('#dosenTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.reports.dosen.datatable') }}",
        order: [
          [2, 'desc']
        ], // urut berdasarkan jumlah BAP terbanyak
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            className: 'text-center',
            width: '60px'
          },
          {
            data: 'nama',
            name: 'nama'
          },
          {
            data: 'bap_count',
            name: 'bap_count',
            className: 'text-center',
            width: '160px'
          },
          {
            data: 'aksi',
            name: 'aksi',
            orderable: false,
            searchable: false,
            className: 'text-center',
            width: '130px'
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
