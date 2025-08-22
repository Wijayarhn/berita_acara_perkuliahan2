<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Laporan BAP</title>
  <style>
    body {
      font-family: sans-serif;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 12px;
    }

    th,
    td {
      border: 1px solid #000;
      padding: 5px;
      text-align: left;
    }
  </style>
</head>

<body>
  <h2>Laporan BAP</h2>
  <p><strong>Mata Kuliah:</strong> {{ $jadwal->nama_mk }}</p>
  <p><strong>Kelas:</strong> {{ $jadwal->kelas }}</p>
  <p><strong>Dosen:</strong> {{ $jadwal->nama_dosen }}</p>

  <table>
    <thead>
      <tr>
        <th>Pertemuan</th>
        <th>Tanggal</th>
        <th>Materi</th>
        <th>Lokasi</th>
        <th>Jumlah Hadir</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($baps as $bap)
        <tr>
          <td>{{ $bap->pertemuan_ke }}</td>
          <td>{{ $bap->tanggal }}</td>
          <td>{{ $bap->materi }}</td>
          <td>{{ $bap->lokasi_dosen }}</td>
          <td>{{ $bap->jumlah_hadir }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>
