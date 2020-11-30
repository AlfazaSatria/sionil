@extends('template_backend.home')
@section('heading', 'Entry Nilai Rapot')
@section('page')
  <li class="breadcrumb-item active">Entry Nilai Rapot</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12" style="margin-top: -21px;">
                <table class="table">
                    <tr>
                        <td>Nama Tahfiz</td>
                        <td>:</td>
                        <td>{{ $tahfiz->nama_tahfiz }}</td>
                    </tr>
                    <tr>
                        <td>Mata Pelajaran</td>
                        <td>:</td>
                        <td>{{ $tahfiz->mapel->nama_mapel }}</td>
                    </tr>
                </table>
                <hr>
            </div>
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
                      <td>{{ $data[0]->rapot($val)->nama_kelas }}</td>
                      <td>
                        <a href="{{ route('tahfiz.show-rapot', Crypt::encrypt(['id'=>$val])) }}" class="btn btn-info btn-md">
                            <i class="fas fa-info-circle"></i>
                            Entry Nilai Rapot
                            <a/>
                        
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
    $("#NilaiTahfiz").addClass("active");
    $("#liNilaiTahfiz").addClass("menu-open");
    $("#UlanganTahfiz").addClass("active");
  </script>
@endsection