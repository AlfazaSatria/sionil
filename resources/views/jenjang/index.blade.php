@extends('layouts.app')
@section('title','jenjang')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Modul jenjang</div>

                <div class="card-body">
                    
                    <a href="/jenjang/create" class="btn btn-danger">Input Data Baru</a>
                    <hr>

                    @include('alert')


                    <table class="table table-bordered" id="users-table">
                            <thead>
                                <tr>
                                    <th width="100">Kode jenjang</th>
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

@push('scripts')
<script>
$(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/jenjang/json',
        columns: [
            { data: 'kode_jenjang', name: 'kode_jenjang' },
            { data: 'nama_jenjang', name: 'nama_jenjang' },
            { data: 'action', name: 'action' }
        ]
    });
});
</script>
@endpush

@endsection




