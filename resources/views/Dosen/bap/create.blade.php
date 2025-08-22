@extends('layouts.app')

@section('title', 'Buat Berita Acara')

@section('contents')
  <div class="container-fluid mt-4">
    <h3 class="mb-4">📝 Buat Berita Acara</h3>

    <!-- Form Pilih Jadwal -->
    <!-- Form Pilih Jadwal -->
    <form method="GET" action="{{ route('dosen.bap.create') }}" class="mb-4">
      <div class="row">
        <div class="col-md-10">
          <select name="jadwal_id" class="form-select" required onchange="this.form.submit()">
            <option value="">-- Pilih Jadwal Kuliah --</option>
            @foreach ($jadwals as $item)
              <option value="{{ $item->id }}" {{ request('jadwal_id') == $item->id ? 'selected' : '' }}>
                {{ $item->nama_mk }} - {{ $item->kelas }} ({{ $item->hari }} {{ $item->waktu }})
              </option>
            @endforeach
          </select>
        </div>
      </div>
    </form>

    <!-- Tampilkan Form Jika Jadwal Terpilih -->
    @if ($jadwal)
      <!-- Informasi Jadwal -->
      <div class="card mb-4">
        <div class="card-body">
          <h5><strong>{{ $jadwal->nama_mk }} ({{ $jadwal->kode_mk }})</strong></h5>
          <p><strong>Hari:</strong> {{ $jadwal->hari }}</p>
          <p><strong>Waktu:</strong> {{ $jadwal->waktu }}</p>
          <p><strong>Kelas:</strong> {{ $jadwal->kelas }}</p>
          <p><strong>Ruang:</strong> {{ $jadwal->ruang }}</p>
        </div>
      </div>

      <!-- Form BAP -->
      <form action="{{ route('dosen.bap.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="jadwal_kuliah_id" value="{{ $jadwal->id }}">

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="pertemuan_ke" class="form-label">Pertemuan Ke-</label>
            <input type="number" class="form-control" name="pertemuan_ke" required>
          </div>

          <div class="col-md-6 mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" name="tanggal" required>
          </div>

          <div class="col-md-12 mb-3">
            <label for="materi" class="form-label">Materi</label>
            <textarea name="materi" class="form-control" rows="3" required></textarea>
          </div>

          <div class="col-md-12 mb-3">
            <label for="pokok_bahasan" class="form-label">Pokok Bahasan (Opsional)</label>
            <textarea name="pokok_bahasan" class="form-control" rows="2"></textarea>
          </div>

          <div class="col-md-12 mb-3">
            <label for="deskripsi_tugas" class="form-label">Deskripsi Tugas (Opsional)</label>
            <textarea name="deskripsi_tugas" class="form-control" rows="2"></textarea>
          </div>

          <!-- Jumlah Mahasiswa -->
          <div class="col-md-6 mb-3">
            <label class="form-label">Jumlah Mahasiswa</label>
            <input type="number" class="form-control" id="jumlah_mhs" value="{{ count($mahasiswaList) }}" readonly>
          </div>

          <!-- Jumlah Hadir -->
          <div class="col-md-6 mb-3">
            <label for="jumlah_hadir" class="form-label">Jumlah Mahasiswa Hadir</label>
            <input type="number" class="form-control" name="jumlah_hadir" id="jumlah_hadir" readonly>
          </div>

          <!-- Tidak Hadir (otomatis) -->
          <div class="col-md-6 mb-3">
            <label for="jumlah_tidak_hadir" class="form-label">Jumlah Tidak Hadir</label>
            <input type="number" class="form-control" name="jumlah_tidak_hadir" id="jumlah_tidak_hadir" readonly>
          </div>

          <!-- Lokasi -->
          <div class="col-md-6 mb-3">
            <label for="lokasi" class="form-label">Lokasi</label>
            <div class="input-group">
              <input type="text" class="form-control" id="lokasi" name="lokasi" readonly required>
              <button type="button" class="btn btn-outline-primary" onclick="getLocation()">📍 Ambil Lokasi</button>
            </div>
            <small class="text-muted">Klik tombol untuk mendeteksi lokasi Anda.</small>
          </div>

          <!-- Dokumentasi -->
          <div class="col-md-6 mb-3">
            <label for="dokumentasi" class="form-label">Dokumentasi (opsional)</label>
            <input type="file" class="form-control" name="dokumentasi">
          </div>
          @if ($jadwal)
            <div class="col-md-12 mb-3">
              <h5 class="mb-3">Absensi Mahasiswa</h5>
              <div class="table-responsive">
                <table class="table-bordered table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>NIM</th>
                      <th>Hadir</th>
                      <th>Tidak Hadir</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $no = 1; @endphp
                    @foreach ($mahasiswaList as $mhs)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $mhs->nama }}</td>
                        <td>{{ $mhs->nim }}</td>
                        <td class="text-center">
                          <input type="checkbox" class="cek-hadir" name="kehadiran[{{ $mhs->id }}][hadir]"
                            value="1">
                        </td>
                        <td class="text-center">
                          <input type="checkbox" class="cek-tidak-hadir"
                            name="kehadiran[{{ $mhs->id }}][tidak_hadir]" value="1">
                        </td>
                        <td>
                          <input type="text" name="kehadiran[{{ $mhs->id }}][keterangan]" class="form-control"
                            placeholder="Opsional">
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          @endif

          <div class="col-md-12 text-end">
            <a href="{{ route('dosen.bap.index') }}" class="btn btn-secondary">← Kembali</a>
            <button type="submit" class="btn btn-success">Simpan BAP</button>
          </div>
        </div>
      </form>

      <!-- Script Lokasi & Hitung -->
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const jumlahMhs = parseInt(document.getElementById('jumlah_mhs').value);
          const jumlahHadirInput = document.getElementById('jumlah_hadir');
          const jumlahTidakHadirInput = document.getElementById('jumlah_tidak_hadir');

          function updateCount() {
            let hadir = 0;
            let tidakHadir = 0;

            document.querySelectorAll('tr').forEach(row => {
              const hadirCb = row.querySelector('.cek-hadir');
              const tidakHadirCb = row.querySelector('.cek-tidak-hadir');

              if (hadirCb && tidakHadirCb) {
                if (hadirCb.checked) hadir++;
                if (tidakHadirCb.checked) tidakHadir++;
              }
            });

            jumlahHadirInput.value = hadir;
            jumlahTidakHadirInput.value = tidakHadir;
          }

          // Handle saling eksklusif
          document.querySelectorAll('.cek-hadir').forEach(hadirCb => {
            hadirCb.addEventListener('change', function() {
              const row = this.closest('tr');
              const tidakHadirCb = row.querySelector('.cek-tidak-hadir');
              if (this.checked) tidakHadirCb.checked = false;
              updateCount();
            });
          });

          document.querySelectorAll('.cek-tidak-hadir').forEach(tidakHadirCb => {
            tidakHadirCb.addEventListener('change', function() {
              const row = this.closest('tr');
              const hadirCb = row.querySelector('.cek-hadir');
              if (this.checked) hadirCb.checked = false;
              updateCount();
            });
          });

          // Inisialisasi awal
          updateCount();
        });

        function getLocation() {
          if (!navigator.geolocation) {
            alert('Geolocation tidak didukung oleh browser Anda.');
            return;
          }

          navigator.geolocation.getCurrentPosition(
            function(position) {
              const lat = position.coords.latitude;
              const lon = position.coords.longitude;
              document.getElementById('lokasi').value = lat + ',' + lon;
            },
            function(error) {
              switch (error.code) {
                case error.PERMISSION_DENIED:
                  alert("Izin lokasi ditolak.");
                  break;
                case error.POSITION_UNAVAILABLE:
                  alert("Informasi lokasi tidak tersedia.");
                  break;
                case error.TIMEOUT:
                  alert("Permintaan lokasi terlalu lama.");
                  break;
                default:
                  alert("Terjadi kesalahan saat mengambil lokasi.");
              }
            }
          );
        }

        function hitungTidakHadir() {
          const jumlahMhs = parseInt(document.getElementById('jumlah_mhs').value);
          const jumlahHadir = parseInt(document.getElementById('jumlah_hadir').value);

          let tidakHadir = jumlahMhs - jumlahHadir;
          if (isNaN(tidakHadir) || tidakHadir < 0) {
            tidakHadir = 0;
          }

          document.getElementById('jumlah_tidak_hadir').value = tidakHadir;
        }
      </script>
    @endif
  </div>
@endsection
