<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Laporan BAP</title>
  <style>
    body {
      font-family: sans-serif;
      font-size: 12px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1em;
    }

    th,
    td {
      border: 1px solid #ccc;
      padding: 5px;
    }

    th {
      background: #f2f2f2;
    }
  </style>
</head>

<body>
  <h2>Laporan Semua BAP</h2>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Dosen</th>
        <th>Mata Kuliah</th>
        <th>Tanggal</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($baps as $i => $bap)
        <tr>
          <td>{{ $i + 1 }}</td>
          <td>{{ $bap->dosen->nama }}</td>
          <td>{{ $bap->jadwal->nama_mk }}</td>
          <td>{{ $bap->tanggal }}</td>
          <td>{{ ucfirst($bap->status_verifikasi) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>
