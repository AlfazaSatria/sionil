@extends('template_backend.home')

<?php
    $tipe = ($rapot_a[0]->tipe_rapot == 0) ? 'Tengah Semester' : 'Akhir Semester';
?>

@section('heading', 'Nilai Rapot '.$tipe)
@section('page')
  <li class="breadcrumb-item active">Nilai Rapot {{$tipe}}</li>
@endsection
@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Nilai Rapot Siswa</h3>

      </div>
        <button class="pull-right">Hello</button>
      <!-- /.card-header -->
      <!-- form start -->
        @csrf
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
                <table class="table" style="margin-top: -10px;">
                    <tr>
                        <td>No Induk Siswa</td>
                        <td>:</td>
                        <td>{{ Auth::user()->no_induk }}</td>
                    </tr>
                    <tr>
                        <td>Nama Siswa</td>
                        <td>:</td>
                        <td class="text-capitalize">{{ Auth::user()->name }}</td>
                    </tr>
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
                <div class="row">
                    <div class="col-12 mb-3">
                        <h4 class="mb-3">A. Affective</h4>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th colspan="2" class="text-center">Description</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <?php
                                    $affective = \App\Affective::where([
                                        'siswa_id' => $siswa->id,
                                    ])->get()->first();
                                ?>
                                <th width="200">1. Spritual Attitude</th>
                                <td>{{ $affective->spiritual }}</td>
                            </tr>
                            <tr>
                                <th width="200">2. Social Attitude</th>
                                <td>{{ $affective->social }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 mb-3">
                        <h4 class="mb-3">B. Pengetahuan dan Keterampilan</h4>
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="ctr">No.</th>
                                    <th rowspan="2">Mata Pelajaran</th>
                                    <th class="ctr" colspan="3">Pengetahuan</th>
                                    <th class="ctr" colspan="3">Keterampilan</th>
                                </tr>
                                <tr>
                                    <th class="ctr" width="50">N</th>
                                    <th class="ctr" width="50">P</th>
                                    <th class="ctr">Deskripsi</th>
                                    <th class="ctr" width="50">N</th>
                                    <th class="ctr" width="50">P</th>
                                    <th class="ctr">Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rapot_a as $key => $data)
                                    <tr>
                                        <th class="ctr">{{ $loop->iteration }}.</th>
                                        <th>{{ $data->nama_mapel }}</th>
                                        <td class="ctr">{{ $data->p_nilai }}</td>
                                        <td class="ctr">{{ $data->p_predikat }}</td>
                                        <td class="ctr">{{ $data->p_deskripsi }}</td>
                                        <td class="ctr">{{ $data->k_nilai }}</td>
                                        <td class="ctr">{{ $data->k_predikat }}</td>
                                        <td class="ctr">{{ $data->k_deskripsi }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th class="ctr">{{ count($rapot_a) + 1 }}.</th>
                                    <th>Thematic Learning</th>
                                    <td class="ctr"></td>
                                    <td class="ctr"></td>
                                    <td class="ctr"></td>
                                    <td class="ctr"></td>
                                    <td class="ctr"></td>
                                    <td class="ctr"></td>
                                </tr>
                                @foreach($rapot_b as $key => $data)
                                    <tr>
                                        <td></td>
                                        <td>({{ $key+1  }}.) {{ $data->nama_mapel }}</td>
                                        <td class="ctr">{{ $data->p_nilai }}</td>
                                        <td class="ctr">{{ $data->p_predikat }}</td>
                                        <td class="ctr">{{ $data->p_deskripsi }}</td>
                                        <td class="ctr">{{ $data->k_nilai }}</td>
                                        <td class="ctr">{{ $data->k_predikat }}</td>
                                        <td class="ctr">{{ $data->k_deskripsi }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="2" class="text-right">Total Score</th>
                                    <th class="ctr" colspan="2">{{ $total_a_p + $total_b_p }}</th>
                                    <th class="text-right">Total Score</th>
                                    <th class="ctr" colspan="2">{{ $total_a_k + $total_b_k }}</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-right">Average</th>
                                    <th class="ctr" colspan="2">{{ ($total_a_p + $total_b_p) / (count($rapot_a) + count($rapot_b)) }}</th>
                                    <th class="text-right">Average</th>
                                    <th class="ctr" colspan="2">{{ ($total_a_k + $total_b_k) / (count($rapot_a) + count($rapot_b)) }}</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th class="ctr">{{ count($rapot_a) + count($rapot_b) + 1 }}.</th>
                                    <th>Islamic Learning</th>
                                    <td class="ctr"></td>
                                    <td class="ctr"></td>
                                    <td class="ctr"></td>
                                    <td class="ctr"></td>
                                    <td class="ctr"></td>
                                    <td class="ctr"></td>
                                </tr>
                                @foreach($rapot_c as $key => $data)
                                    <tr>
                                        <td></td>
                                        <td>({{ $key+1  }}.) {{ $data->nama_mapel }}</td>
                                        <td class="ctr">{{ $data->p_nilai }}</td>
                                        <td class="ctr">{{ $data->p_predikat }}</td>
                                        <td class="ctr">{{ $data->p_deskripsi }}</td>
                                        <td class="ctr">{{ $data->k_nilai }}</td>
                                        <td class="ctr">{{ $data->k_predikat }}</td>
                                        <td class="ctr">{{ $data->k_deskripsi }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="2" class="text-right">Total Score</th>
                                    <th class="ctr" colspan="2">{{ $total_c_p }}</th>
                                    <th class="text-right">Total Score</th>
                                    <th class="ctr" colspan="2">{{ $total_c_k }}</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-right">Average</th>
                                    <th class="ctr" colspan="2">{{ $total_c_p / count($rapot_c) }}</th>
                                    <th class="text-right">Average</th>
                                    <th class="ctr" colspan="2">{{ $total_c_k / count($rapot_c) }}</th>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 mb-3">
                        <h4 class="mb-3">C. Extra Curricular</h4>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="ctr">No.</th>
                                <th>Extra Curricular Activity</th>
                                <th class="ctr">Score</th>
                                <th>Description</th>
                            </tr>
                            @foreach($extracurricular as $key => $data)
                                <tr>
                                    <td class="ctr">{{ $loop->iteration }}.</td>
                                    <td>{{ $data->mapel_name }}</td>
                                    <td>{{ $data->score }}</td>
                                    <td>{{ $data->description }}</td>
                                </tr>
                            @endforeach
                            </thead>
                        </table>
                    </div>
                    <div class="col-12 mb-3">
                        <h4 class="mb-3">D. Teacher's Remark</h4>
                        <div style="border:1px solid #ddd; border-radius:2px; padding:40px;">
                            {{ $remark->note }}
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <h4 class="mb-3">E. Physical Appearance</h4>
                        <table class="table table-bordered table-sm">
                            <thead>
                            <tr>
                                <th class="ctr" rowspan="2">No.</th>
                                <th rowspan="2">Rated Aspects</th>
                                <th colspan="2" class="ctr">Semester</th>
                            </tr>
                            <tr>
                                <th class="ctr">1</th>
                                <th class="ctr">2</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="ctr">2</td>
                                <td>Weight</td>
                                <td class="ctr">{{ $physical->weight_sem1 }}</td>
                                <td class="ctr">{{ $physical->weight_sem2 }}</td>
                            </tr>
                            <tr>
                                <td class="ctr">1</td>
                                <td>Height</td>
                                <td class="ctr">{{ $physical->height_sem1 }}</td>
                                <td class="ctr">{{ $physical->height_sem2 }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 mb-3">
                        <h4 class="mb-3">G. Health Condition</h4>
                        <table class="table table-bordered table-sm">
                            <thead>
                            <tr>
                                <th class="ctr">No.</th>
                                <th>Physical Aspect</th>
                                <th>Description</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($health as $data)
                                    <tr>
                                        <td class="ctr">{{ $loop->iteration }}.</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->description }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 mb-3">
                        <h4 class="mb-3">F. Achievement</h4>
                        <table class="table table-bordered table-sm">
                            <thead>
                            <tr>
                                <th class="ctr">No.</th>
                                <th>Kind of Achievement</th>
                                <th>Description</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($achievement as $data)
                                <tr>
                                    <td class="ctr">{{ $loop->iteration }}.</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->description }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-3">
                        <table class="table table-bordered table-sm">
                            <tr><th class="ctr" colspan="2">Attendance</th></tr>
                            <tr>
                                <td>Sick</td>
                                <td class="ctr"> {{ $attendance->sick }}</td>
                            </tr>
                            <tr>
                                <td>Permission</td>
                                <td class="ctr"> {{ $attendance->permission }}</td>
                            </tr>
                            <tr>
                                <td>Absence</td>
                                <td class="ctr"> {{ $attendance->absent }}</td>
                            </tr>
                            <tr>
                                <td>Late</td>
                                <td class="ctr"> {{ $attendance->late }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
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
        $("#liNilaiRapotSiswa").addClass("menu-open");

        var tipe = "{{ $tipe }}";
        if (tipe.includes('Tengah')) {
            $("#RapotSiswaUTS").addClass('active');
        } else {
            $("#RapotSiswaUAS").addClass('active');
        }
    </script>
@endsection