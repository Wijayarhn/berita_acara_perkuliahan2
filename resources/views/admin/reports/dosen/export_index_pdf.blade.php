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
        <strong></strong><br><br>
        <br>
        <strong></strong>
      </td>
    </tr>
    <tr>
      <td style="text-align: center;"><strong></strong></td>
      <td style="text-align: center;"><strong></strong></td>
    </tr>
  </table>

  <div class="judul-form">Laporan BAP per Dosen</div>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Dosen</th>
        <th>Jumlah BAP</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($dosens as $index => $dosen)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $dosen->nama }}</td>
          <td>{{ $dosen->bap_count }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>
