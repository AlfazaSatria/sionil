@extends('layouts.app')
@section('title','Data siswa')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Modul siswa</div>

                <div class="card-body">
                    
                    <a href="/siswa/create" class="btn btn-danger">Input Data Baru</a>
                    {{-- <a href="/siswa/create" class="btn btn-success"><i class="far fa-file-excel"></i> Export Excel</a> --}}
                    <hr>

                    @include('alert')

                    <div class="row">
                        <div class="col-md-4">
                            <table class="table table-bordered">
                                <tr><td>Pilih kelas</td></tr>
                                
                                <tr><td>{{ Form::select('kelas',$kelas,null,['class'=>'form-control kelas','onChange'=>'ubah_kelas()','multiple'])}}</td></tr>
                                <tr><td>Pilih Tahun Akademik</td></tr>
                                <tr><td>{{ Form::select('tahun_aakdemik',$tahun_akademik,null,['class'=>'form-control','multiple'])}}</td></tr>
                            </table>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered" id="users-table">
                                <thead>
                                    <tr>
                                        <th width="100">NISN</th>
                                        <th>Nama</th>
                                        <th width="53">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
        $(document).ready(function() {
            tampil_data();
          });
</script>

<script>

    function tampil_data()
    {
        $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/siswa/json',
                columns: [
                    { data: 'nisn', name: 'nisn' },
                    { data: 'nama_siswa', name: 'nama_siswa' },
                    { data: 'action', name: 'action' }
                ]
            });
        });
    }

    function ubah_kelas()
    {
        var kelas = $(".kelas").val();
        alert(kelas);
        //tampil_data();
        $.ajax({
            type: "GET",
            url: '/siswa/json',
            data: {kelas: kelas},
            success: function( msg ) {
                //$("#ajaxResponse").append("<div>"+msg+"</div>");
                alert('ok');
            }
        });


        $('#users-table').DataTable().ajax.reload();
    }
</script>
@endpush
