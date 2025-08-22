@extends('layouts.mahasiswa.app')
@section('title', 'Riwayat Tanda Tangan BAP')

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
          <table id="riwayatTable" class="table-bordered table" width="100%" cellspacing="0">
            <thead>
              <tr class="text-center">
                <th>#</th>
                <th>Mata Kuliah</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th> {{-- Tambahan --}}
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
  script src="{{ asset('admin_assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script>
    $(function() {
      $('#riwayatTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('mahasiswa.bap.riwayat.datatable') }}",
        order: [
          [0, 'desc']
        ],
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
            name: 'bap.jadwal.nama_mk'
          },
          {
            data: 'tanggal',
            name: 'bap.tanggal',
            className: 'text-center',
            width: '140px'
          },
          {
            data: 'status_text',
            name: 'bap.status_verifikasi',
            className: 'text-center',
            width: '140px',
            render: function(d, t) {
              if (t !== 'display') return d;
              const map = {
                Disetujui: 'success',
                Ditolak: 'danger',
                Belum: 'warning',
                Ditandatangani: 'info'
              };
              const text = d || 'Ditandatangani';
              const cls = map[text] || 'secondary';
              const dark = (cls === 'warning') ? 'text-dark' : '';
              return `<span class="badge bg-${cls} ${dark}">${text}</span>`;
            }
          },
          {
            data: 'aksi', // Tambahan
            name: 'aksi',
            orderable: false,
            searchable: false,
            className: 'text-center',
            width: '100px'
          }
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
