@extends('template_backend.home')
@section('heading', 'Edit Jadwal Tahfiz')
@section('page')
  <li class="breadcrumb-item active"><a href="{{ route('jadwalTahfiz.index') }}">Jadwal Tahfiz</a></li>
  <li class="breadcrumb-item active">Edit Jadwal Tahfiz</li>
@endsection
@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Edit Data Jadwal Tahfiz</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{ route('jadwalTahfiz.store') }}" method="post">
        @csrf
        <div class="card-body">
          <div class="row">
            <input type="hidden" name="jadwalTahfiz_id" value="{{ $jadwalTahfiz->id }}">
            <div class="col-md-6">
              <div class="form-group">
                <label for="hari_id">Hari</label>
                <select id="hari_id" name="hari_id" class="form-control @error('hari_id') is-invalid @enderror select2bs4">
                  <option value="">-- Pilih Hari --</option>
                  @foreach ($hari as $data)
                    <option value="{{ $data->id }}"
                      @if ($jadwalTahfiz->hari_id == $data->id)
                        selected
                      @endif
                    >{{ $data->nama_hari }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="kelas_id">Kelas</label>
                <select id="kelas_id" name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror select2bs4">
                  <option value="">-- Pilih Kelas --</option>
                  @foreach ($kelas as $data)
                  <option value="{{ $data->id }}"
                      @if ($jadwalTahfiz->kelas_id == $data->id)
                        selected
                      @endif
                    >{{ $data->nama_kelas }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="tahfiz_id">Kode Mapel</label>
                <select id="tahfiz_id" name="tahfiz_id" class="form-control @error('tahfiz_id') is-invalid @enderror select2bs4">
                  <option value="" @if ($jadwalTahfiz->tahfiz_id)
                    selected
                  @endif>-- Pilih Kode Mapel --</option>
                  @foreach ($tahfiz as $data)
                    <option value="{{ $data->id }}"
                      @if ($jadwalTahfiz->tahfiz_id == $data->id)
                        selected
                      @endif
                    >{{ $data->kode }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="jam_mulai">Jam Mulai</label>
                <input type='time' value="{{ $jadwal->jam_mulai }}" id="jam_mulai" name='jam_mulai' class="form-control @error('jam_mulai') is-invalid @enderror" placeholder='JJ:mm:dd'>
              </div>
              <div class="form-group">
                <label for="jam_selesai">Jam Selesai</label>
                <input type='time' value="{{ $jadwal->jam_selesai }}" name='jam_selesai' class="form-control @error('jam_selesai') is-invalid @enderror" placeholder='JJ:mm:dd'>
              </div>
              <div class="form-group">
                <label for="ruang_id">Ruang Kelas</label>
                <select id="ruang_id" name="ruang_id" class="form-control @error('ruang_id') is-invalid @enderror select2bs4">
                    <option value="">-- Pilih Ruang Kelas --</option>
                    @foreach ($ruang as $data)
                        <option value="{{ $data->id }}"
                          @if ($jadwalTahfiz->ruang_id == $data->id)
                            selected
                          @endif
                        >{{ $data->nama_ruang }}</option>
                    @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <a href="#" name="kembali" class="btn btn-default" id="back"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</a> &nbsp;
          <button name="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Update</button>
        </div>
      </form>
    </div>
    <!-- /.card -->
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $('#back').click(function() {
        window.location="{{ route('jadwalTahfiz.show', Crypt::encrypt($jadwalTahfiz->kelas_id)) }}";
        });
    });
    $("#MasterData").addClass("active");
    $("#liMasterData").addClass("menu-open");
    $("#DataJadwalTahfiz").addClass("active");
</script>
@endsection