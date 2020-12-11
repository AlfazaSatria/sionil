@extends('template_backend.home')
@section('heading', 'Data Kelas')
@section('page')
  <li class="breadcrumb-item active">Data Term</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
          <h3 class="card-title">
              <button type="button" class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#form-term">
                  <i class="nav-icon fas fa-folder-plus"></i> &nbsp; Update Data Term
              </button>
          </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    
                    <th>Term</th>
                    <th>Semester</th>
                    <th>Kepsek</th>
                    <th>delivered_on</th>
                </tr>
            </thead>
            <tbody>
               
                <tr>
                   
                    <td>{{ $term->term }}</td>
                    <td>{{ $term->semester }}</td>
                    <td>{{ $term->kepsek}}</td>
                    <th>{{$term->delivered_on}}</th>
                </tr>
 
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.col -->

<!-- Extra large modal -->
<div class="modal fade bd-example-modal-md" id="form-term" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title" id="judul"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
    <form action="{{ route('admin.term.simpan') }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" id="id" name="id" value="{{$term->id}}"></input>
           
              
              <div class="form-group">
                <label for="term">Term</label>
                <input type="text" name="term" class="form-control" value="{{$term->term}}"></input>
                <label for="Semester" >Semester</label>
                <input type="text" name="semester" class="form-control" value="{{$term->term}}"></input>
                <label for="Kepala Sekolah">Kepala Sekolah</label>
                <input type="text" name="kepsek" class="form-control" value="{{$term->kepsek}}"></input>
                <label for="Delivered On">Delivered On</label>
                <input type="date" name="delivered_on" value="{{$term->delivered_on}}"></input>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</button>
            <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Update</button>
      </form>
      </div>
    </div>
  </div>
</div>


@endsection
