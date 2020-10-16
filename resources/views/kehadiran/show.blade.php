@extends('layouts.dosen')
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


                    <table class="table table-bordered">
                        <tr><td width="170">Nama Matakuliah</td><td>{{ $kehadiran->nama_mk}}</td></tr>
                        <tr><td>Nama Dosen</td><td>{{ $kehadiran->nama }}</td></tr>
                        <tr><td>Pertemuan Ke</td><td>{{ $kehadiran->pertemuan_ke }} </td></tr>
                        <tr><td>Topik</td><td>{{ $kehadiran->topik_pembahasan}}</td></tr>
                    </table>

                    <table class="table table-bordered">
                        <tr>
                            <th width="170">nisn</th>
                            <th>Nama siswa</th>
                            <th width="200">Kehadiran</th>
                        </tr>
                        @foreach($siswa as $row)
                        <tr>
                            <td>{{ $row->nisn}}</td>
                            <td>{{ $row->nama_siswa }}</td>
                            <td>
                                {{ Form::select('kehadiran',['H'=>'Hadir','I'=>'Izin','A'=>'Tidak Hadir','S'=>'Sakit'],null,['id'=>'absen-'.$row->nisn,'class'=>'form-control','onChange'=>'simpan_kehadiran('.Request::segment(2).',"'.$row->nisn.'")'])}}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>

    function simpan_kehadiran(id_kehadiran,nisn)
    {
        var status_kehadiran = $("#absen-"+nisn).val();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var pertemuan_ke = {{ Request::segment(2)}}
        //alert(pertemeuan_ke);

        $.post("/kehadiran/update",
        {
          id_kehadiran : id_kehadiran,
          nisn : nisn,
          pertemuan_ke : pertemuan_ke,
          status_kehadiran : status_kehadiran,
          _token: CSRF_TOKEN
        },
        function(data, status){
          alert('sukses')
      });
    }
</script>
@endpush
