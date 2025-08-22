@extends('layouts.app')

@section('title', 'Laporan Detail BAP')

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
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1 class="mb-0">📄 Laporan Detail BAP - {{ $jadwal->nama_mk }} ({{ $jadwal->kelas }})</h1>
      <div class="btn-group btn-group-sm">
        <a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        <a href="{{ route('dosen.reports.pdf', $jadwal->id) }}" class="btn btn-danger"><i class="fas fa-file-pdf"></i>
          Export PDF</a>
      </div>
    </div>

    <div class="card shadow">
      <div class="card-body">
        <div class="table-responsive">
          <table id="reportsShowTable" class="table-bordered table" width="100%" cellspacing="0">
            <thead>
              <tr class="text-center">
                <th>Pertemuan</th>
                <th>Tanggal</th>
                <th>Materi</th>
                <th>Kelas</th>
                <th>Jumlah Hadir</th>
                <th>Lokasi</th>
                <th>TTD Dosen</th>
                <th>TTD Mhs (x/y)</th>
                <th>Status</th>
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
      $('#reportsShowTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('dosen.reports.show.datatable', $jadwal->id) }}",
        order: [
          [0, 'asc']
        ],
        columns: [{
            data: 'pertemuan_ke',
            name: 'pertemuan_ke',
            className: 'text-center',
            width: '110px'
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

          // kelas dari relasi → non-sort/search
          {
            data: 'kelas',
            orderable: false,
            searchable: false,
            className: 'text-center',
            width: '90px',
            defaultContent: '-'
          },

          // ✅ hadapinya error tadi di sini:
          {
            data: 'hadir_count',
            name: 'hadir_count',
            className: 'text-center',
            width: '120px',
            defaultContent: '0'
          },

          {
            data: 'lokasi_dosen',
            name: 'lokasi_dosen',
            className: 'text-center',
            width: '140px',
            defaultContent: '-'
          },
          {
            data: 'ttd_dosen',
            orderable: false,
            searchable: false,
            className: 'text-center',
            width: '110px',
            defaultContent: '❌'
          },
          {
            data: 'ttd_mhs',
            orderable: false,
            searchable: false,
            className: 'text-center',
            width: '130px',
            defaultContent: '0/0'
          },
          {
            data: 'status_teks',
            orderable: false,
            searchable: false,
            className: 'text-center',
            width: '140px',
            defaultContent: '-'
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
