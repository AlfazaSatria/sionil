@extends('template_backend.home')
<?php
    $title = "Entry Nilai Indikator ";
?>
@section('heading', $title)
@section('page')
  <li class="breadcrumb-item ">Entry Nilai</li>
  <li class="breadcrumb-item active">Indikator</li>
@endsection
@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
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
                        <td>{{ $tahfiz->mapel->nama_mapel }}</td>
                    </tr>
                    <tr>
                        <td>Guru Mata Pelajaran</td>
                        <td>:</td>
                        <td>{{ $tahfiz->nama_tahfiz }}</td>
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
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Siswa</th>
                            @foreach($indikatorTahfiz as $key => $indikator)
                            <th>
                                Indikator {{ $key+1 }}
                                <i class="fas fa-info-circle text-gray" 
                                    style="cursor:pointer"
                                    data-toggle="modal" 
                                    data-target="{{ "#indikatorDialog".$key }}"></i>
                                <div id="{{ "indikatorDialog".$key }}" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <i class="fas fa-info-circle fa-lg text-gray"></i> &nbsp;&nbsp;
                                                Indikator {{ $key+1 }}
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body" style="font-weight:lighter">
                                                {{ $indikator->indikator }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswa as $key => $siswa) 
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $siswa->nama_siswa }}</td>
                                @foreach($indikatorTahfiz as $key => $indikator) 
                                <?php
                                    $nilai = "";
                                    $baris="";
                                    $salah="";
                                    $data_nilai = $indikator->nilai($siswa->id);
                                    if (count($data_nilai) > 0) {
                                        $baris = $data_nilai[0]->baris;
                                        $salah = $data_nilai[0]->salah;
                                        $nilai = $data_nilai[0]->nilai_indikator;
                                    }
                                ?>
                                <td>
                                    <form action="{{ route('tahfiz.input-nilai-indikator') }}" method="post" class="input-group">
                                        @csrf
                                        <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                                        <input type="hidden" name="indikator_id" value="{{ $indikator->id }}">
                                        <input type="number" class="form-control" name="baris" value="{{$baris}}" placeholder="Baris Ayat">
                                        <input type="number" class="form-control" name="salah" value="{{$salah}}" placeholder="Baris Salah">
                                        <input type="text" class="form-control" disabled value="{{(int)$nilai}}">
                                        <div class="input-group-append">
                                            <button class="btn btn-info btn-sm" type="submit">
                                                <i class="fas fa fa-save"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                                @endforeach
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
        $("#NilaiTahfiz").addClass("active");
        $("#liNilaiTahfiz").addClass("menu-open");
        $("#NilaiTahfiz").addClass("active");
    </script>
@endsection