@extends('layouts.app')

@section('title', 'Detail Jadwal Perkuliahan')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5>Detail Jadwal Perkuliahan</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Mata Kuliah</th>
                        <td>{{ $jadwal->mataKuliah->nama_mk }}</td>
                    </tr>
                    <tr>
                        <th>Hari</th>
                        <td>{{ $jadwal->hari }}</td>
                    </tr>
                    <tr>
                        <th>Jam Mulai</th>
                        <td>{{ $jadwal->jam_mulai }}</td>
                    </tr>
                    <tr>
                        <th>Jam Selesai</th>
                        <td>{{ $jadwal->jam_selesai }}</td>
                    </tr>
                </table>
                <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
