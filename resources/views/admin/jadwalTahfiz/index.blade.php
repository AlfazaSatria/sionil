@extends('template_backend.home')
@section('heading', 'Data Jadwal Tahfiz')
@section('page')
  <li class="breadcrumb-item active">Data Jadwal Tahfiz</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
      <div class="card-header">
          <h3 class="card-title">
              <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target=".tambah-jadwal">
                  <i class="nav-icon fas fa-folder-plus"></i> &nbsp; Tambah Data Jadwal Tahfiz
              </button>
              <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#dropTable">
                  <i class="nav-icon fas fa-minus-circle"></i> &nbsp; Drop
              </button>
          </h3>
      </div>
        <div class="modal fade" id="dropTable" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <form method="post" action="{{ route('jadwalTahfiz.deleteAll') }}">
              @csrf
              @method('delete')
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Sure you drop all data?</h5>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cencel</button>
                  <button type="submit" class="btn btn-danger">Drop</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Kelas</th>
                    <th>Lihat Jadwal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kelas as $data)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->nama_kelas }}</td>
                    <td>
                      <a href="{{ route('jadwalTahfiz.show', Crypt::encrypt($data->id)) }}" class="btn btn-info btn-sm"><i class="nav-icon fas fa-search-plus"></i> &nbsp; Ditails</a>
                    </td>
                  </tr>
                @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.col -->

<!-- Extra large modal -->
<div class="modal fade bd-example-modal-lg tambah-jadwal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title">Tambah Data Jadwal Tahfiz</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
          <form action="{{ route('jadwalTahfiz.store') }}" method="post">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="hari_id">Hari</label>
                  <select id="hari_id" name="hari_id" class="form-control @error('hari_id') is-invalid @enderror select2bs4">
                      <option value="">-- Pilih Hari --</option>
                      @foreach ($hari as $data)
                          <option value="{{ $data->id }}">{{ $data->nama_hari }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="kelas_id">Kelas</label>
                  <select id="kelas_id" name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror select2bs4">
                      <option value="">-- Pilih Kelas --</option>
                      @foreach ($kelas as $data)
                          <option value="{{ $data->id }}">{{ $data->nama_kelas }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="tahfiz_id">Kode Guru Tahfiz</label>
                  <select id="tahfiz_id" name="tahfiz_id" class="form-control @error('tahfiz_id') is-invalid @enderror select2bs4">
                      <option value="">-- Pilih Kode Guru Tahfiz--</option>
                      @foreach ($tahfiz as $data)
                          <option value="{{ $data->id }}">{{ $data->kode }}</option>
                      @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="jam_mulai">Jam Mulai</label>
                  <input type='time' id="jam_mulai" name='jam_mulai' class="form-control @error('jam_mulai') is-invalid @enderror" placeholder='JJ:mm:dd'>
                </div>
                <div class="form-group">
                  <label for="jam_selesai">Jam Selesai</label>
                  <input type='time' name='jam_selesai' class="form-control @error('jam_selesai') is-invalid @enderror" placeholder='JJ:mm:dd'>
                </div>
                <div class="form-group">
                  <label for="ruang_id">Ruang Kelas</label>
                  <select id="ruang_id" name="ruang_id" class="form-control @error('ruang_id') is-invalid @enderror select2bs4">
                      <option value="">-- Pilih Ruang Kelas --</option>
                      @foreach ($ruang as $data)
                          <option value="{{ $data->id }}">{{ $data->nama_ruang }}</option>
                      @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</button>
              <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan</button>
          </form>
      </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
    <script>
        $("#MasterData").addClass("active");
        $("#liMasterData").addClass("menu-open");
        $("#DataJadwalTahfiz").addClass("active");
    </script>
@endsection