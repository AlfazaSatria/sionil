@extends('template_backend.home')
@section('heading', 'Details tahfiz')
@section('page')
  <li class="breadcrumb-item active"><a href="{{ route('tahfiz.index') }}">tahfiz</a></li>
  <li class="breadcrumb-item active">Details tahfiz</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <a href="{{ route("tahfiz.mapel", Crypt::encrypt($tahfiz->mapel_id)) }}" class="btn btn-default btn-sm"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</a>
        </div>
        <div class="card-body">
            <div class="row no-gutters ml-2 mb-2 mr-2">
                <div class="col-md-4">
                    <img src="{{ asset($tahfiz->foto) }}" class="card-img img-details" alt="...">
                </div>
                <div class="col-md-1 mb-4"></div>
                <div class="col-md-7">
                    <h5 class="card-title card-text mb-2">Nama : {{ $tahfiz->nama_tahfiz }}</h5>
                    <h5 class="card-title card-text mb-2">NIP : {{ $tahfiz->nip }}</h5>
                    <h5 class="card-title card-text mb-2">No Id Card : {{ $tahfiz->id_card }}</h5>
                    <h5 class="card-title card-text mb-2">tahfiz Mapel : {{ $tahfiz->mapel->nama_mapel }}</h5>
                    <h5 class="card-title card-text mb-2">Kode Jadwal : {{ $tahfiz->kode }}</h5>
                    @if ($tahfiz->jk == 'L')
                        <h5 class="card-title card-text mb-2">Jenis Kelamin : Laki-laki</h5>
                    @else
                        <h5 class="card-title card-text mb-2">Jenis Kelamin : Perempuan</h5>
                    @endif
                    <h5 class="card-title card-text mb-2">Tempat Lahir : {{ $tahfiz->tmp_lahir }}</h5>
                    <h5 class="card-title card-text mb-2">Tanggal Lahir : {{ date('l, d F Y', strtotime($tahfiz->tgl_lahir)) }}</h5>
                    <h5 class="card-title card-text mb-2">No. Telepon : {{ $tahfiz->telp }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $("#MasterData").addClass("active");
        $("#liMasterData").addClass("menu-open");
        $("#DataTahfiz").addClass("active");
    </script>
@endsection