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
                    <hr>

                    @include('alert')


                    <table class="table table-bordered" id="users-table">
                            <thead>
                                <tr>
                                    <th width="100">NISN</th>
                                    <th>Nama</th>
                                    <th>Nama jenjang</th>
                                    <th>kelas</th>
                                    <th width="53">Action</th>
                                </tr>
                            </thead>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
$(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/siswa/json',
        columns: [
            { data: 'nisn', name: 'nisn' },
            { data: 'nama_siswa', name: 'nama_siswa' },
            { data: 'nama_kelas', name: 'nama_kelas' },
            { data: 'nama_jenjang', name: 'nama_jenjang' },
            { data: 'action', name: 'action' }
        ]
    });
});
</script>
@endpush
