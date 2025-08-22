@extends('layouts.mahasiswa.app')

@section('title', 'Tanda Tangan BAP')

@section('contents')
  <div class="container-fluid> <h4 class="mb-3">✍️ Tanda Tangan BAP</h4>

    {{-- Tampilkan detail BAP --}}
    <div class="card mb-4">
      <div class="card-body">
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($bap->tanggal)->format('d M Y') }}</p>
        <p><strong>Mata Kuliah:</strong> {{ $bap->jadwal->nama_mk ?? '-' }}</p>
        <p><strong>Materi:</strong> {{ $bap->materi }}</p>
        <p><strong>Pokok Bahasan:</strong> {{ $bap->pokok_bahasan }}</p>
        <p><strong>Deskripsi Tugas:</strong> {{ $bap->deskripsi_tugas }}</p>
      </div>
    </div>

    {{-- Form TTD --}}
    <form method="POST" action="{{ route('mahasiswa.bap.ttd', $bap->id) }}">
      @csrf

      <div class="mb-3">
        <label for="lokasi_mahasiswa" class="form-label">📍 Lokasi</label>
        <div class="input-group">
          <input type="text" name="lokasi_mahasiswa" id="lokasi_mahasiswa" class="form-control" readonly required>
          <button type="button" class="btn btn-outline-primary" onclick="getLocation()">Ambil Lokasi</button>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">✍️ Tanda Tangan</label>
        <div class="bg-light rounded border" style="width: 100%; overflow-x: auto;">
          <canvas id="signature-pad" width="600" height="200" style="background: #fff; cursor: crosshair;"></canvas>
        </div>
        <button type="button" class="btn btn-sm btn-warning mt-2" onclick="clearSignature()">Hapus Tanda Tangan</button>
        <input type="hidden" name="ttd_mahasiswa" id="ttd_mahasiswa">
      </div>

      <button type="submit" class="btn btn-success" onclick="prepareSignature()">Tandatangani</button>
      <a href="{{ route('mahasiswa.bap.index') }}" class="btn btn-secondary">Batal</a>
    </form>
  </div>

  {{-- JS Geolocation + Signature --}}
  <script>
    function getLocation() {
      if (!navigator.geolocation) {
        alert('Browser tidak mendukung geolokasi.');
        return;
      }
      navigator.geolocation.getCurrentPosition(
        (pos) => {
          document.getElementById('lokasi_mahasiswa').value = `${pos.coords.latitude},${pos.coords.longitude}`;
        },
        (err) => {
          alert('Gagal mendapatkan lokasi: ' + err.message);
        }
      );
    }

    // TTD Signature Pad
    const canvas = document.getElementById('signature-pad');
    const ctx = canvas.getContext('2d');
    let isDrawing = false;

    // Setup default
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.strokeStyle = '#000000';

    // Mouse Events
    canvas.addEventListener('mousedown', (e) => {
      isDrawing = true;
      ctx.beginPath();
      ctx.moveTo(e.offsetX, e.offsetY);
    });

    canvas.addEventListener('mousemove', (e) => {
      if (!isDrawing) return;
      ctx.lineTo(e.offsetX, e.offsetY);
      ctx.stroke();
    });

    canvas.addEventListener('mouseup', () => isDrawing = false);
    canvas.addEventListener('mouseleave', () => isDrawing = false);

    // Touch Events
    canvas.addEventListener('touchstart', function(e) {
      e.preventDefault();
      const touch = e.touches[0];
      const rect = canvas.getBoundingClientRect();
      const x = touch.clientX - rect.left;
      const y = touch.clientY - rect.top;
      isDrawing = true;
      ctx.beginPath();
      ctx.moveTo(x, y);
    });

    canvas.addEventListener('touchmove', function(e) {
      e.preventDefault();
      if (!isDrawing) return;
      const touch = e.touches[0];
      const rect = canvas.getBoundingClientRect();
      const x = touch.clientX - rect.left;
      const y = touch.clientY - rect.top;
      ctx.lineTo(x, y);
      ctx.stroke();
    });

    canvas.addEventListener('touchend', () => isDrawing = false);

    function clearSignature() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
    }

    function prepareSignature() {
      const dataUrl = canvas.toDataURL('image/png');
      document.getElementById('ttd_mahasiswa').value = dataUrl;
    }
  </script>
@endsection
