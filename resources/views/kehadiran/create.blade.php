@extends('layouts.Guru')
@section('title','Daftar Hadir siswa')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Daftar Hadir siswa</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ Form::open(['url'=>'kehadiran/'.Request::segment(2)])}}

                    <table class="table table-bordered">
                        <tr><td width="270">Kode Mata Pelajaran</td><td>{{ $jadwal->kode_mp}}</td></tr>
                        <tr><td>Nama Mata Pelajaran</td><td>{{ $jadwal->nama_mp}}</td></tr>
                        <tr><td>Nama Guru</td><td>{{ $jadwal->nama}}</td></tr>
                        <tr><td>Pertemuan Ke</td><td>{{ $pertemuan_ke }} {{ Form::hidden('pertemuan_ke',$pertemuan_ke )}}</td></tr>
                        <tr><td></td>
                            <td>
                                <button type="submit" class="btn btn-danger">Simpan</button>
                                <a href="/kehadiran/{{ Request::segment(2)}}" class="btn btn-info">Kembali</a>
                            </td>
                        </tr>
                    </table>
                    {{ Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection