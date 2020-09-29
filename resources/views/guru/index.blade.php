@extends('layouts.app')
@section('title','Guru')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Modul Guru</div>

                <div class="card-body">
                    
                    <a href="/guru/create" class="btn btn-danger">Input Data Baru</a>
                    {{-- <a href="/dosen/excel" class="btn btn-danger">Export Ke Excel</a> --}}
                    <hr>

                    @include('alert')


                    <table class="table table-bordered" id="users-table">
                            <thead>
                                <tr>
                                    <th width="70">NIGN</th>
                                    <th>Nama Guru</th>
                                    <th width="40">Email</th>
                                    <th width="40">No HP</th>
                                    <th>Jenjang</th>
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
        ajax: '/guru/json',
        columns: [
            { data: 'nign', name: 'nign' },
            { data: 'nama_guru', name: 'nama_guru' },
            { data: 'email', name: 'email' },
            { data: 'no_hp', name: 'no_hp' },
            { data: 'jenjang', name: 'jenjang' },
            { data: 'action', name: 'action' }
        ]
    });
});
</script>
@endpush
