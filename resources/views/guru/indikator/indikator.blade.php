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
                        <th>Tipe Indikator</th>
                        <th>Indikator</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($indikators as $key => $indikator)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ ($indikator->tipe == "0") ? "Pengetahuan" : "Keterampilan" }}</td>
                            <td>{{ $indikator->indikator }}</td>
                            <td>
                                <button class="btn btn-sm btn-info"
                                        data-toggle="modal"
                                        data-target="{{ "#editIndikator".$indikator->id }}">
                                    <i class="fas fa-pencil-alt"></i>&nbsp;
                                    Edit
                                </button>
                                @include('guru.indikator.edit-indikator', ['data' => $indikator])
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
                                                <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>
                                                    Apakah anda yakin ingin menghapus Indikator ini? <br/>
                                                    <span class="text-bold">
                                                        Data nilai yang berkaitan dengan Indikator ini akan ikut terhapus.
                                                    </span>
                                                </p>

                                            </div>
                                            <form class="modal-footer" action="{{ route('guru.destroy-indikator', $indikator->id) }}" method="post">
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
                <form action="{{ route('guru.store-indikator') }}" method="post" class="modal-content">
                    @csrf
                    <input type="text" name="guru_id" value="{{ $guru->id }}" hidden/>
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data Indikator</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tipe-indikator">Tipe Indikator</label>
                                    <select class="form-control" id="tipe-indikator" name="tipe">
                                        <option value="" disabled selected>Pilih Tipe Indikator</option>
                                        <option value="0">Pengetahuan</option>
                                        <option value="1">Keterampilan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="indikator">Tipe Indikator</label>
                                    <textarea class="form-control" id="indikator" name="indikator"></textarea>
                                </div>
                            </div>
                        </div>
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
                <form action="{{ route('guru.store-indikator') }}" method="post" class="modal-content">
                    @csrf
                    <input type="text" name="guru_id" value="{{ $guru->id }}" hidden/>
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data Indikator</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tipe-indikator">Tipe Indikator</label>
                                    <select class="form-control" id="tipe-indikator" name="tipe-indikator">
                                        <option value="0">Pengetahuan</option>
                                        <option value="0">Keterampilan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="indikator">Tipe Indikator</label>
                                    <textarea class="form-control" id="indikator" name="indikator"></textarea>
                                </div>
                            </div>
                        </div>
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
        $("#IndikatorGuru").addClass("active");
    </script>
@endsection