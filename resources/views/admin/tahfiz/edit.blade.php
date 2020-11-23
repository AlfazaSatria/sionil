@extends('template_backend.home')
@section('heading', 'Edit tahfiz')
@section('page')
  <li class="breadcrumb-item active"><a href="{{ route('tahfiz.index') }}">tahfiz</a></li>
  <li class="breadcrumb-item active">Edit tahfiz</li>
@endsection
@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Edit Data tahfiz</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{ route('tahfiz.update', $tahfiz->id) }}" method="post">
        @csrf
        @method('patch')
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama_tahfiz">Nama tahfiz</label>
                    <input type="text" id="nama_tahfiz" name="nama_tahfiz" value="{{ $tahfiz->nama_tahfiz }}" class="form-control @error('nama_tahfiz') is-invalid @enderror">
                </div>
                <div class="form-group">
                    <label for="mapel_id">Mapel</label>
                    <select id="mapel_id" name="mapel_id" class="select2bs4 form-control @error('mapel_id') is-invalid @enderror">
                        <option value="">-- Pilih Mapel --</option>
                        @foreach ($mapel as $data)
                            <option value="{{ $data->id }}"
                                @if ($tahfiz->mapel_id == $data->id)
                                    selected
                                @endif
                            >{{ $data->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="tmp_lahir">Tempat Lahir</label>
                    <input type="text" id="tmp_lahir" name="tmp_lahir" value="{{ $tahfiz->tmp_lahir }}" class="form-control @error('tmp_lahir') is-invalid @enderror">
                </div>
                <div class="form-group">
                    <label for="id_card">Nomor ID Card</label>
                    <input type="text" id="id_card" name="id_card" class="form-control" value="{{ $tahfiz->id_card }}" readonly>
                </div>
                <div class="form-group">
                    <label for="telp">Nomor Telpon/HP</label>
                    <input type="text" id="telp" name="telp" onkeypress="return inputAngka(event)" value="{{ $tahfiz->telp }}" class="form-control @error('telp') is-invalid @enderror">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nip">NIP</label>
                    <input type="text" id="nip" name="nip" onkeypress="return inputAngka(event)" value="{{ $tahfiz->nip }}" class="form-control @error('nip') is-invalid @enderror" disabled>
                </div>
                <div class="form-group">
                    <label for="jk">Jenis Kelamin</label>
                    <select id="jk" name="jk" class="select2bs4 form-control @error('jk') is-invalid @enderror">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L"
                            @if ($tahfiz->jk == 'L')
                                selected
                            @endif
                        >Laki-Laki</option>
                        <option value="P"
                            @if ($tahfiz->jk == 'P')
                                selected
                            @endif
                        >Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tgl_lahir">Tanggal Lahir</label>
                    <input type="date" id="tgl_lahir" name="tgl_lahir" value="{{ $tahfiz->tgl_lahir }}" class="form-control @error('tgl_lahir') is-invalid @enderror">
                </div>
                <div class="form-group">
                    <label for="kode">Kode Jadwal</label>
                    <input type="text" id="kode" name="kode" class="form-control" value="{{ $tahfiz->kode }}" disabled>
                </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <a href="#" name="kembali" class="btn btn-default" id="back"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</a> &nbsp;
          <button name="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan</button>
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
        window.location="{{ route('tahfiz.mapel', Crypt::encrypt($tahfiz->mapel_id)) }}";
        });
    });
    $("#MasterData").addClass("active");
    $("#liMasterData").addClass("menu-open");
    $("#Datatahfiz").addClass("active");
</script>
@endsection