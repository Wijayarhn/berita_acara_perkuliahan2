@extends('layouts.admin.app')

@section('title', 'Detail BAP per Dosen')

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
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0">📄 Detail BAP – {{ $dosen->nama }}</h4>
      <div>
      </div>
    </div>

    <div class="card shadow-sm">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table-bordered table" id="detailDosenTable" width="100%" cellspacing="0">
            <thead>
              <tr class="text-center">
                <th>No</th>
                <th>Mata Kuliah</th>
                <th>Jumlah BAP</th>
                <th>Disetujui</th>
                <th>Belum</th>
              </tr>
            </thead>
          </table>
        </div>
        <a href="{{ route('admin.reports.dosen.index') }}" class="btn btn-secondary btn-sm">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>
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
      $('#detailDosenTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.reports.dosen.show.datatable', $dosen->id) }}",
        order: [
          [2, 'desc']
        ], // urut berdasarkan jumlah BAP
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            className: 'text-center',
            width: '60px'
          },
          {
            data: 'mata_kuliah',
            name: 'mata_kuliah'
          },
          {
            data: 'total',
            name: 'total',
            className: 'text-center',
            width: '140px'
          },
          {
            data: 'disetujui',
            name: 'disetujui',
            className: 'text-center',
            width: '120px'
          },
          {
            data: 'belum',
            name: 'belum',
            className: 'text-center',
            width: '120px'
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
