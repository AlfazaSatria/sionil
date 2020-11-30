@extends('template_backend.home')
@section('heading', 'Entry Nilai Ulangan')
@section('page')
  <li class="breadcrumb-item active">Entry Nilai</li>
  <li class="breadcrumb-item active">Ulangan</li>
@endsection
@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Entry Nilai Ulangan</h3>
      </div>
      <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
                <table class="table" style="margin-top: -10px;">
                    <tr>
                        <td>Nama Kelas</td>
                        <td>:</td>
                        <td>{{ $kelas->nama_kelas }}</td>
                    </tr>
                    <tr>
                        <td>Wali Kelas</td>
                        <td>:</td>
                        <td>{{ $kelas->guru->nama_guru }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah Siswa</td>
                        <td>:</td>
                        <td>{{ $siswa->count() }}</td>
                    </tr>
                    <tr>
                        <td>Mata Pelajaran</td>
                        <td>:</td>
                        <td>{{ $guru->mapel->nama_mapel }}</td>
                    </tr>
                    <tr>
                        <td>Guru Mata Pelajaran</td>
                        <td>:</td>
                        <td>{{ $guru->nama_guru }}</td>
                    </tr>
                    @php
                        $bulan = date('m');
                        $tahun = date('Y');
                    @endphp
                    <tr>
                        <td>Semester</td>
                        <td>:</td>
                        <td>
                            @if ($bulan > 6)
                                {{ 'Semester Ganjil' }}
                            @else
                                {{ 'Semester Genap' }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Tahun Pelajaran</td>
                        <td>:</td>
                        <td>
                            @if ($bulan > 6)
                                {{ $tahun }}/{{ $tahun+1 }}
                            @else
                                {{ $tahun-1 }}/{{ $tahun }}
                            @endif
                        </td>
                    </tr>
                </table>
                <hr>
            </div>
            <div class="col-md-12">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="ctr">No.</th>
                            <th>Nama Siswa</th>
                            <th class="ctr">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <b class="input-group-text text-bold">UTS</b>
                                    </div>
                                    <select id="tipe_uts" class="custom-select" name="tipe_uts">
                                        <option selected disabled>Pilih Jenis UTS</option>
                                        <option value="0">Teori</option>
                                        <option value="1">Praktikum</option>
                                    </select>
                                </div>
                            </th>
                            <th class="ctr">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-bold">UAS</span>
                                    </div>
                                    <select id="tipe_uas" class="custom-select" name="tipe_uas">
                                        <option selected disabled>Pilih Jenis UAS</option>
                                        <option value="0">Teori</option>
                                        <option value="1">Praktikum</option>
                                    </select>
                                </div>
                            </th>
                            <th class="ctr">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <input type="hidden" id="kelas_id" value="{{ $guru->id }}" />
                        <input type="hidden" id="guru_id" value="{{ $kelas->id }}" />
                        <input type="hidden" id="mapel_id" value="{{ $guru->mapel->id }}" />
                        @foreach($siswa as $key => $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->nama_siswa }}</td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input id="{{"nilai_uts_".$value->id}}" class="form-control form-control-sm"
                                               type="number"
                                               name="nilai_uts"/>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input id="{{"nilai_uas_".$value->id}}" class="form-control form-control-sm"
                                               type="number"
                                               name="nilai_uas"/>
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-default btn-sm form-control form-control-sm"
                                            onclick="save('{{$value->id}}')">
                                        <i class="fas fa-save"></i> &nbsp;
                                        Simpan
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
@endsection
@section('script')
    <script>
        $("#NilaiGuru").addClass("active");
        $("#liNilaiGuru").addClass("menu-open");
        $("#UlanganGuru").addClass("active");

        function save(siswaId) {
            var data = {
                'siswa_id': siswaId,
                'kelas_id': $("#kelas_id").val(),
                'guru_id': $("#guru_id").val(),
                'mapel_id': $("#mapel_id").val(),
                'tipe_uts': $("#tipe_uts").val(),
                'uts': $("#nilai_uts_" + siswaId).val(),
                'tipe_uas': $("#tipe_uas").val(),
                'uas': $("#nilai_uas_" + siswaId).val(),
            }

            $.ajax({
                url: "{{ route('guru.store-ulangan') }}",
                type: "POST",
                dataType: "JSON",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'item': data,
                },
                success: (response) => {
                    toastr.success(response.message);
                },
                error: (err) => {
                    toastr.warning(err.message);
                }
            })

        }
    </script>
@endsection