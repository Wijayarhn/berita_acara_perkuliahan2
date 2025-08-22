<!DOCTYPE html>
<html>

<head>
  <title>Berita Acara Perkuliahan</title>
  <style>
    body {
      font-family: sans-serif;
      font-size: 12px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th,
    td {
      border: 1px solid black;
      padding: 6px;
    }
  </style>
</head>

<body>
  <h4>Berita Acara Perkuliahan</h4>
  <p>Dosen: {{ $dosen->nama }}</p>
  <p>Mata Kuliah: {{ $jadwal->nama_mk }}</p>

  <table>
    <thead>
      <tr>
        <th>Pertemuan</th>
        <th>Tanggal</th>
        <th>Materi</th>
        <th>Jumlah Hadir</th>
        <th>Lokasi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($baps as $bap)
        <tr>
          <td>{{ $bap->pertemuan }}</td>
          <td>{{ $bap->tanggal }}</td>
          <td>{{ $bap->materi }}</td>
          <td>{{ $bap->jumlah_hadir }}</td>
          <td>{{ $bap->lokasi }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>
