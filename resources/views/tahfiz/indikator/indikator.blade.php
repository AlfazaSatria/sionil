@extends('template_backend.home')
@section('heading', 'Entry Indikator')
@section('page')
    <li class="breadcrumb-item active">Entry Indikator</li>
@endsection
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <button type="button"
                        class="btn btn-default btn-sm"
                        data-toggle="modal"
                        data-target=".modal-indikator-add">
                    <i class="nav-icon fas fa-folder-plus"></i> &nbsp; Tambah Indikator
                </button>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Indikator</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($indikators as $key => $indikator)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $indikator->indikator }}</td>
                            <td>
                                <button class="btn btn-sm btn-info"
                                        data-toggle="modal"
                                        data-target="{{ "#editIndikator".$indikator->id }}">
                                    <i class="fas fa-pencil-alt"></i>&nbsp;
                                    Edit
                                </button>
                                @include('tahfiz.indikator.edit-indikator', ['data' => $indikator])
                                <button class="btn btn-sm btn-danger"
                                        data-toggle="modal"
                                        data-target="{{ "#deleteDialog".$indikator->id }}">
                                    <i class="fas fa-trash"></i>&nbsp;
                                    Hapus
                                </button>
                                <div class="modal fade" id="{{"deleteDialog".$indikator->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">Apakah anda yakin ingin menghapus Indikator ini?</div>
                                            <form class="modal-footer" action="{{ route('tahfiz.destroy-indikator', $indikator->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade modal-indikator-add"
         tabindex="-1"
         role="dialog"
         aria-hidden="true">
        <div class="col-md-4 offset-4">
            <div class="modal-dialog modal-lg" role="document">
                <form action="{{ route('tahfiz.store-indikator') }}" method="post" class="modal-content">
                    @csrf
                    <input type="text" name="tahfiz_id" value="{{ $tahfiz->id }}" hidden/>
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data Indikator</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-indikator-add"
         tabindex="-1"
         role="dialog"
         aria-hidden="true">
        <div class="col-md-4 offset-4">
            <div class="modal-dialog modal-lg" role="document">
                <form action="{{ route('tahfiz.store-indikator') }}" method="post" class="modal-content">
                    @csrf
                    <input type="text" name="tahfiz_id" value="{{ $tahfiz->id }}" hidden/>
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data Indikator</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal-dialog">

    </div>
@endsection
@section('script')
    <script>
        $("#IndikatorTahfiz").addClass("active");
    </script>
@endsection