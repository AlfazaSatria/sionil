<div id="{{ "editIndikator".$data->id }}" class="modal fade" role="dialog" aria-hidden="true">
    <div class="col-md-4 offset-4">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('tahfiz.store-indikator') }}" method="post" class="modal-content">
                @csrf
                <input type="text" name="id" value="{{ $data->id }}" hidden readonly>
                <input type="text" name="tahfiz_id" value="{{ $data->tahfiz_id }}" hidden readonly>
                <div class="modal-header">
                    <h4 class="modal-title">Edit Indikator</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="indikator">Indikator</label>
                                <textarea class="form-control" id="indikator"
                                    name="indikator">{{$data->indikator}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp;
                        Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>