@extends('template_backend.home')
<?php
$tipe_ujian = ($tipe == 'uts') ? "Tengah" : "Akhir";
$tipe_rapot = ($tipe == 'uts') ? 0 : 1;
$matchThese = [
    'tipe_rapot' => $tipe_rapot,
    'kelas_id' => $kelas->id,
    'guru_id' => $guru->id,
    'mapel_id' => $mapel->id,
];
?>
@section('heading', 'Rapot '.$tipe_ujian.' Semester')
@section('page')
    <li class="breadcrumb-item">Rapot</li>
  <li class="breadcrumb-item active">{{$tipe_ujian}} Semester</li>
@endsection
@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
{{--        <h3 class="card-title">Entry Nilai Rapot</h3>--}}
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
                        <td>{{ count($siswa) }}</td>
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
                            <th class="ctr" rowspan="2">No.</th>
                            <th rowspan="2">Nama Siswa</th>
                            <th class="ctr" colspan="3">Pengetahuan</th>
                            <th class="ctr" colspan="3">Keterampilan</th>
                            <th class="ctr" rowspan="2">Aksi</th>
                        </tr>
                        <tr>
                            <th class="ctr">Nilai</th>
                            <th class="ctr">Predikat</th>
                            <th class="ctr">Deskripsi</th>
                            <th class="ctr">Nilai</th>
                            <th class="ctr">Predikat</th>
                            <th class="ctr">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswa as $key => $val)
                            <?php
                                $nilai = \App\Rapot::where($matchThese)
                                    ->where('siswa_id', $val['id'])
                                    ->get()
                                    ->first();
                                $exists = ($nilai) ? true : false;
                            ?>

                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$val['nama']}}</td>
                                <td>
                                    {{$val['pengetahuan']['nilai']}}
                                    <input type="hidden" id="p_nilai_{{$val['id']}}" value="{{$val['pengetahuan']['nilai']}}"/>
                                </td>
                                <td>
                                    {{$val['pengetahuan']['predikat']}}
                                    <input type="hidden" id="p_predikat_{{$val['id']}}" value="{{$val['pengetahuan']['predikat']}}"/>
                                </td>
                                <td>
                                    {{$val['pengetahuan']['deskripsi']}}
                                    <input type="hidden" id="p_deskripsi_{{$val['id']}}" value="{{$val['pengetahuan']['deskripsi']}}"/>
                                </td>
                                <td>
                                    {{$val['keterampilan']['nilai']}}
                                    <input type="hidden" id="k_nilai_{{$val['id']}}" value="{{$val['keterampilan']['nilai']}}"/>
                                </td>
                                <td>
                                    {{$val['keterampilan']['predikat']}}
                                    <input type="hidden" id="k_predikat_{{$val['id']}}" value="{{$val['keterampilan']['predikat']}}"/>
                                </td>
                                <td>
                                    {{$val['keterampilan']['deskripsi']}}
                                    <input type="hidden" id="k_deskripsi_{{$val['id']}}" value="{{$val['keterampilan']['deskripsi']}}"/>
                                </td>
                                <td>
                                    <button class="btn btn-default btn-sm form-control form-control-sm"
                                            id="saveBtn{{$val['id']}}"
                                            {{ ($exists) ? "disabled":"" }}
                                            onclick="save('{{$val['id']}}')">
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
        $("#RapotGuru").addClass("active");
        $("#liNilaiGuru").addClass("menu-open");

        function save(siswaId) {
            let data = {
                _token: "{{ csrf_token() }}",
                tipe_rapot: "{{ $tipe_rapot }}",
                siswa_id: siswaId,
                kelas_id: {{ $kelas->id }},
                guru_id: {{ $guru->id }},
                mapel_id: {{ $guru->mapel->id }},
                p_nilai: $("#p_nilai_"+siswaId).val(),
                p_predikat: $("#p_predikat_"+siswaId).val(),
                p_deskripsi: $("#p_deskripsi_"+siswaId).val(),
                k_nilai: $("#k_nilai_"+siswaId).val(),
                k_predikat: $("#k_predikat_"+siswaId).val(),
                k_deskripsi: $("#k_deskripsi_"+siswaId).val(),
            };

            console.log(data);

            $.ajax({
                url: '{{ route('guru.store-rapot') }}',
                type: "POST",
                dataType: "JSON",
                data: data,
                success: (response) => {
                    $("#saveBtn"+siswaId).attr("disabled", true);
                    toastr.success(response.message);
                },
                error: (err) => {
                    toastr.warning(response.message);
                }
            })
        }
    </script>
@endsection
