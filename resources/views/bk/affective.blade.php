@extends('template_backend.home')
@section('heading', 'Entry Nilai Affective')
@section('page')
  <li class="breadcrumb-item active">Entry Nilai Affective</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <table id="example2" class="table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Nama Kelas</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                  @foreach ($kelas as $val => $data)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $data->nama_kelas }}</td>
                      <td>                       
                        <button class="btn btn-info btn-sm" type="submit">
                            <a href="{{ route('bk.show', Crypt::encrypt(['encryption'=>$data->id])) }}" class="nav-link text-light" id="AffectiveSiswa">Input Affective</a>
                        </button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
@section('script')
  <script>
    $("#NilaiGuru").addClass("active");
    $("#liNilaiGuru").addClass("menu-open");
    $("#UlanganGuru").addClass("active");
  </script>
@endsection