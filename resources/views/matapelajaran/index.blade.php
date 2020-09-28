@extends('layouts.app')
@section('title','Mata Pelajaran')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@yield('title')</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <a href="/matapelajaran/create" class="btn btn-primary">Input Data Baru</a>
                    <hr>
                    <table class="table table-bordered" id="users-table">
                        <thead>
                            <tr>
                                <th>Kode MP</th>
                                <th>Nama Mata Pelajaran</th>
                                <th>jumlah Jam</th>
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
        ajax: '/matapelajaran/json',
        columns: [
            { data: 'kode_mp', name: 'kode_mp' },
            { data: 'nama_mp', name: 'nama_mp' },
            { data: 'jml_jam', name: 'jml_jam' }
        ]
    });
});
</script>
@endpush

@endsection
