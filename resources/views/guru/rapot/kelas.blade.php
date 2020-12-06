@extends('template_backend.home')
@section('heading', 'Penilaian')
@section('page')
    <li class="breadcrumb-item active">Penilaian</li>
    <li class="breadcrumb-item active">Nilai Semester</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12" style="margin-top: -21px;">
                <table class="table">
                    <tr>
                        <td>Nama Guru</td>
                        <td>:</td>
                        <td>{{ $guru->nama_guru }}</td>
                    </tr>
                    <tr>
                        <td>Mata Pelajaran</td>
                        <td>:</td>
                        <td>{{ $guru->mapel->nama_mapel }}</td>
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
                  @foreach ($kelas as $data)
                    <?php
                        $nilai_uts = DB::table('ulangan')
                            ->join('kelas', 'ulangan.kelas_id', '=', 'kelas.id')
                            ->join('siswa', 'ulangan.siswa_id', '=', 'siswa.id')
                            ->where([
                                ['kelas.id', '=', $data->id],
                            ])
                            ->whereNotNull('ulangan.uts')
                            ->count();
                        $nilai_uas = DB::table('ulangan')
                            ->join('kelas', 'ulangan.kelas_id', '=', 'kelas.id')
                            ->join('siswa', 'ulangan.siswa_id', '=', 'siswa.id')
                            ->where([
                                ['kelas.id', '=', $data->id],
                            ])
                            ->whereNotNull('ulangan.uas')
                            ->count();
                        $siswa = \App\Siswa::where([
                            ['kelas_id', '=', $data->id],
                        ])->count();
                    ?>
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $data->nama_kelas }}</td>
                      <td>
                          <a href="{{ route('guru.show-rapot', Crypt::encrypt(['id' => $data->id, 'tipe' => 'uts'])) }}"
                             class="btn btn-primary btn-sm <?= ($siswa != $nilai_uts) ? "disabled":"" ?>">
                              <i class="nav-icon fas fa-pen"></i> &nbsp;
                              Nilai Tengah Semester
                          </a>
                          <a href="{{ route('guru.show-rapot', Crypt::encrypt(['id' => $data->id, 'tipe' => 'uas'])) }}"
                             class="btn btn-primary btn-sm <?= ($siswa != $nilai_uas) ? "disabled":"" ?>">
                              <i class="nav-icon fas fa-pen"></i> &nbsp;
                              Nilai Akhir Semester
                          </a>
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
    $("#RapotGuru").addClass("active");
  </script>
@endsection