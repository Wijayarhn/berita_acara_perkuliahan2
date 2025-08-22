<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Berita Acara Perkuliahan</title>
  <style>
    body {
      font-family: sans-serif;
      font-size: 12px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    th,
    td {
      border: 1px solid black;
      padding: 5px;
      vertical-align: top;
      text-align: left;
    }

    .judul-form {
      text-align: center;
      margin-top: 10px;
      font-weight: bold;
      font-size: 16px;
      text-decoration: underline;
    }

    .catatan {
      margin-top: 10px;
      font-size: 11px;
    }
  </style>
</head>

<body>
  <table style="width: 100%; border: 1px solid black; margin-bottom: 0;">
    <tr>
      <td style="width: 20%; text-align: center;">
        <img src="{{ public_path('admin_assets/img/binabangsa.png') }}" alt="Logo"
          style="width: 70px; display: block; margin: auto;">
      </td>
      <td style="width: 60%; text-align: center; font-size: 12px;">
        <strong>UNIVERSITAS BINA BANGSA</strong><br>
        Kampus : Jl. Raya Serang - Jakarta, KM. 03 No. 1B Pakupatan<br>
        Telp : (0254) 220158, Fax : (0254) 220157<br>
        Website : <u>www.binabangsa.ac.id</u>,<br>
        e-Mail : <u>bpm@binabangsa.ac.id</u><br>
        <strong>KOTA SERANG - BANTEN</strong>
      </td>
      <td style="width: 20%; text-align: center; font-size: 12px;" rowspan="2">
        <strong>Formulir</strong><br><br>
        No. Dokumen<br>
        <strong>AMI-02</strong>
      </td>
    </tr>
    <tr>
      <td style="text-align: center;"><strong>FORMULIR</strong></td>
      <td style="text-align: center;"><strong>BERITA ACARA PERKULIAHAN</strong></td>
    </tr>
  </table>

  <div class="judul-form">FORMULIR BERITA ACARA PERKULIAHAN</div>

  <table>
    <tr>
      <td>Fakultas</td>
      <td colspan="3">FAKULTAS ILMU KOMPUTER</td>
    </tr>
    <tr>
      <td>Kode Mata Kuliah</td>
      <td>{{ $bap->jadwal->kode_mk ?? '-' }}</td>
      <td>Mata Kuliah</td>
      <td>{{ $bap->jadwal->nama_mk ?? '-' }}</td>
    </tr>
    <tr>
      <td>Nama Dosen</td>
      <td>{{ $bap->dosen->nama ?? '-' }}</td>
      <td>NIDN</td>
      <td>{{ $bap->dosen->nidn ?? '-' }}</td>
    </tr>
    <tr>
      <td>Hari/Tanggal</td>
      <td>{{ $bap->jadwal->hari ?? '-' }}, {{ \Carbon\Carbon::parse($bap->tanggal)->translatedFormat('d F Y') }}</td>
      <td>Jam</td>
      <td>{{ $bap->jadwal->waktu ?? '-' }}</td>
    </tr>
    <tr>
      <td>Program Studi</td>
      <td>{{ $bap->jadwal->prodi ?? '-' }}</td>
      <td>Semester</td>
      <td>{{ $bap->jadwal->semester ?? '-' }}</td>
    </tr>
    <tr>
      <td>Kelas</td>
      <td>{{ $bap->jadwal->kelas ?? '-' }}</td>
      <td>Ruangan</td>
      <td>{{ $bap->jadwal->ruang ?? '-' }}</td>
    </tr>
    <tr>
      <td>Pertemuan Ke</td>
      <td>{{ $bap->pertemuan_ke ?? '-' }}</td>
      <td>Jumlah Hadir</td>
      <td>{{ $bap->jumlah_hadir ?? '-' }}</td>
    </tr>
    <tr>
      <td>Jumlah Tidak Hadir</td>
      <td>{{ $bap->jumlah_tidak_hadir ?? '-' }}</td>
      <td colspan="2"></td>
    </tr>
    <tr>
      <td colspan="4"><strong>Pokok Bahasan:</strong><br>{{ $bap->pokok_bahasan ?? '-' }}</td>
    </tr>
    <tr>
      <td colspan="4"><strong>Materi Pembahasan:</strong><br>{{ $bap->materi ?? '-' }}</td>
    </tr>
    <tr>
      <td colspan="4"><strong>Deskripsi Tugas yang Diberikan:</strong><br>{{ $bap->deskripsi_tugas ?? '-' }}</td>
    </tr>
  </table>

  <br><strong>Yang Menandatangani:</strong><br><br>

  <table style="width: 100%; border: none; margin-bottom: 60px;">
    <tr>
      <td style="width: 45%; text-align: center; vertical-align: top; border: none;">
        Dosen yang bersangkutan:<br><br>
        @if ($bap->ttd_dosen)
          <img src="data:image/png;base64,{{ $bap->ttd_dosen }}" alt="TTD Dosen" width="100"
            style="margin-bottom: 10px;"><br>
        @else
          <div style="height: 50px;"></div>
        @endif
        <strong>{{ $bap->dosen->nama ?? '-' }}</strong><br>
        NIDN: {{ $bap->dosen->nidn ?? '-' }}
      </td>

      <td style="width: 10%; border: none;"></td> <!-- Spacer -->

      <td style="width: 45%; text-align: center; vertical-align: top; border: none;">
        Mahasiswa yang TTD:<br><br>
        @php
          $ttdMahasiswa = $bap->bapMahasiswa->filter(fn($bm) => $bm->ttd_mahasiswa)->take(2);
        @endphp

        @forelse ($ttdMahasiswa as $index => $bm)
          <div style="margin-bottom: 20px;">
            <strong>{{ $bm->mahasiswa->nama ?? '-' }}</strong><br>
            NIM: {{ $bm->mahasiswa->nim ?? '-' }}<br>
            @if ($bm->ttd_mahasiswa)
              @php
                $base64 = $bm->ttd_mahasiswa;
                if (!str_starts_with($base64, 'data:image')) {
                    $base64 = 'data:image/png;base64,' . $base64;
                }
              @endphp
              <img src="{{ $base64 }}" alt="TTD Mahasiswa" width="100" style="margin-top: 5px;">
            @else
              <div style="height: 80px;"></div>
            @endif
          </div>
        @empty
          <div style="height: 80px;"></div>
        @endforelse
      </td>
    </tr>
  </table>

  <div style="text-align: center; margin-top: 40px;">
    Mengetahui/Memeriksa:<br><br>
    <div style="height: 50px;"></div>
    Ka. Prodi / Sek. Prodi / Ka. TU Fakultas
  </div>

  <div class="catatan">
    <strong>Catatan:</strong><br>
    1. Berita Acara Sah tanpa menggunakan Tanda Tangan<br>
    2. Berita Acara ini untuk satu Mata Kuliah yang diampu.<br>
    3. TU Fakultas membuat laporan rekapitulasi dosen mengajar untuk dilaporkan ke Biro Keuangan setiap periode
    tertentu.<br>
    4. Formulir ini dapat digandakan oleh dosen yang bersangkutan sesuai dengan kebutuhan.
  </div>

</body>

</html>
