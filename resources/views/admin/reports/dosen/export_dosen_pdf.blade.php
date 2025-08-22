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

    .subjudul {
      text-align: center;
      margin-top: 5px;
      font-size: 14px;
      font-weight: bold;
    }

    .catatan {
      margin-top: 10px;
      font-size: 11px;
    }

    .header-table td {
      border: none;
      padding: 5px;
    }
  </style>
</head>

<body>
  <table class="header-table" style="width: 100%; border: 1px solid black; margin-bottom: 0;">
    <tr>
      <td style="width: 20%; text-align: center;">
        <img src="{{ public_path('admin_assets/img/binabangsa.png') }}" alt="Logo"
          style="width: 70px; display: block; margin: auto;">
      </td>
      <td style="width: 60%; text-align: center; font-size: 12px;">
        <strong>UNIVERSITAS BINA BANGSA</strong><br>
        Kampus : Jl. Raya Serang - Jakarta, KM. 03 No. 1B Pakupatan<br>
        Telp : (0254) 220158, Fax : (0254) 220157<br>
        Website : <u>www.binabangsa.ac.id</u> | e-Mail : <u>bpm@binabangsa.ac.id</u><br>
        <strong>KOTA SERANG - BANTEN</strong>
      </td>
      <td style="width: 20%; text-align: center; font-size: 12px;" rowspan="2">
        <!-- Bisa diisi informasi dokumen / kode form -->
      </td>
    </tr>
    <tr>
      <td style="text-align: center;"><strong>Fakultas Ilmu Komputer</strong></td>
      <td style="text-align: center;"><strong>Dokumen Berita Acara Perkuliahan</strong></td>
    </tr>
  </table>

  <div class="judul-form">Laporan BAP per Dosen</div>
  <div class="subjudul">Detail BAP: {{ $dosen->nama }}</div>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Mata Kuliah</th>
        <th>Tanggal</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($baps as $index => $bap)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $bap->jadwal->nama_mk ?? '-' }}</td>
          <td>{{ \Carbon\Carbon::parse($bap->tanggal)->format('d-m-Y') }}</td>
          <td>{{ ucfirst($bap->status_verifikasi ?? 'Belum diverifikasi') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>
