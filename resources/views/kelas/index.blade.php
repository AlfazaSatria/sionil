@extends('layouts.app')
@section('title','Data kelas')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Modul kelas</div>

                <div class="card-body">
                    
                    <a href="/kelas/create" class="btn btn-danger">Input Data Baru</a>
                    <hr>

                    @include('alert')


                    <table class="table table-bordered" id="users-table">
                            <thead>
                                <tr>
                                    <th width="100">Kode kelas</th>
                                    <th>Nama kelas</th>
                                    <th>Nama jenjang</th>
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
        ajax: '/kelas/json',
        columns: [
            { data: 'kode_kelas', name: 'kode_kelas' },
            { data: 'nama_kelas', name: 'nama_kelas' },
            { data: 'nama_jenjang', name: 'nama_jenjang' },
            { data: 'action', name: 'action' }
        ]
    });
});
</script>
@endpush
