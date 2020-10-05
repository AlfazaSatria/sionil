@extends('layouts.app')
@section('title','Jadwal pelajaran')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Jadwal pelajaran</div>

                <div class="card-body">

                    @include('validation_error')
                    
             

                        <div class="row">
                            <div class="col-md-4">
                                {{ Form::open(['url'=>'jadwalpelajaran','method'=>'GET'])}}

                                @csrf

                                <table class="table table-bordered">
                                    <tr>
                                        <td>kelas</td>
                                        <td>{{ Form::select('kelas',$kelas,$kelas_terpilih,['class'=>'form-control'])}}</td></tr>
                                    <tr>
                                        <td>Semester</td>
                                        <td>{{ Form::select('semester',['1'=>'Semester 1','2'=>'Semester 2','3'=>'Semester 3','4'=>'Semester 4','5'=>'Semester 5','6'=>'Semester 6','7'=>'Semester 7','8'=>'Semester 8'],$semester_terpilih,['class'=>'form-control'])}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-plus-square"></i> Refresh Data</button>
                                            <a href="/jadwalpelajaran/create" class="btn btn-danger"><i class="fas fa-plus-square"></i> Input Jadwal</a>
                                        </td></tr>
                                </table>

                            </form>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <tr><th>HARI</th><th>JAM</th><th>MATApelajaran</th><th>GURU</th><th>RUANG</th><th></th></tr>
                                    @foreach($jadwal as $row)
                                    <tr>
                                        <td>{{ $row->hari }}</td>
                                        <td>{{ $row->jam }}</td>
                                        <td>{{ $row->nama_mp }}</td>
                                        <td>{{ $row->nama }}</td>
                                        <td>{{ $row->nama_ruangan }}</td>
                                        <td><a href="jadwalpelajaran/{{ $row->id }}/edit"><i class="fas fa-edit"></i></a></td>
                                    <tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
