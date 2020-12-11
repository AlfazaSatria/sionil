@extends('template_backend.home')
@section('heading', 'Deskripsi Nilai Affective')
@section('page')
<li class="breadcrumb-item active">Deskripsi Nilai Affective</li>
@endsection
@section('content')
<div class="col-md-12">
  <!-- general form elements -->
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Deskripsi Nilai</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="{{ route('bk.deskripsi.simpan') }}" method="post">
      @csrf
      <div class="card-body">
        <div class="row">
          
          <input type="hidden" name="id" value="{{ $deskripsi->id }}">
          <div class="col-md-6">
            <h2>Spiritual Description</h2>
            
            <div class="form-group">
              <label for="deskripsi_a_sp">Deskripsi A</label>
              <textarea class="form-control" name="deskripsi_a_sp" id="deskripsi_a_sp" rows="4"
                value="{{ $deskripsi->deskripsi_a_sp }}">{{ $deskripsi->deskripsi_a_sp }}</textarea>
            </div>
            <div class="form-group">
              <label for="deskripsi_c_sp">Deskripsi C</label>
              <textarea class="form-control" name="deskripsi_c_sp" id="deskripsi_c_sp" rows="4"
                value="{{ $deskripsi->deskripsi_c_sp }}">{{ $deskripsi->deskripsi_c_sp }}</textarea>
            </div>
          </div>
          <div class="col-md-6">
            <h2>Spiritual Description</h2>
            <div class="form-group">
              <label for="deskripsi_b_sp">Deskripsi B</label>
              <textarea class="form-control" name="deskripsi_b_sp" id="deskripsi_b_sp" rows="4"
                value="{{ $deskripsi->deskripsi_b_sp }}">{{ $deskripsi->deskripsi_b_sp }}</textarea>
            </div>
            <div class="form-group">
              <label for="deskripsi_d_sp">Deskripsi D</label>
              <textarea class="form-control" name="deskripsi_d_sp" id="deskripsi_d_sp" rows="4"
                value="{{ $deskripsi->deskripsi_d_sp }}">{{ $deskripsi->deskripsi_d_sp }}</textarea>
            </div>
          </div>

        </div>
        <br><br>
        <div class="row">
          <div class="col-md-6">
            <h2>Social Description</h2>
            <div class="form-group">
              <label for="deskripsi_a_so">Deskripsi A </label>
              <textarea class="form-control" name="deskripsi_a_so" id="deskripsi_a_so" rows="4"
                value="{{ $deskripsi->deskripsi_a_so }}">{{ $deskripsi->deskripsi_a_so }}</textarea>
            </div>
            <div class="form-group">
              <label for="deskripsi_c_so">Deskripsi C</label>
              <textarea class="form-control" name="deskripsi_c_so" id="deskripsi_c_so" rows="4"
                value="{{ $deskripsi->deskripsi_c_so }}">{{ $deskripsi->deskripsi_c_so}}</textarea>
            </div>
          </div>
          <div class="col-md-6">
            <h2>Social Description</h2>
            <div class="form-group">
              <label for="deskripsi_b_so">Deskripsi B</label>
              <textarea class="form-control" name="deskripsi_b_so" id="deskripsi_b_so" rows="4"
                value="{{ $deskripsi->deskripsi_b_so }}">{{ $deskripsi->deskripsi_b_so }}</textarea>
            </div>
            <div class="form-group">
              <label for="deskripsi_d_so">Deskripsi D</label>
              <textarea class="form-control" name="deskripsi_d_so" id="deskripsi_d_so" rows="4"
                value="{{ $deskripsi->deskripsi_d_so }}">{{ $deskripsi->deskripsi_d_so }}</textarea>
            </div>
          </div>
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <a href="#" name="kembali" class="btn btn-default" id="back"><i class='nav-icon fas fa-arrow-left'></i> &nbsp;
          Kembali</a> &nbsp;
        <button name="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan</button>
      </div>
    </form>
  </div>
  <!-- /.card -->
</div>
@endsection
@section('spript')
<spript type="text/javaspript">
  $(document).ready(function() {
  $('#back').click(function() {
  window.location="{{ url('/') }}";
  });
  });
  $("#NilaiGuru").addClass("active");
  $("#liNilaiGuru").addClass("menu-open");
  $("#DesGuru").addClass("active");
</spript>
@endsection