@extends('template_backend.home')
<?php
    $tipe = ($indikators[0]->tipe) ? "Keterampilan" : "Pengetahuan";
    $title = "Entry Nilai Indikator ".$tipe;
?>
@section('heading', $title)
@section('page')
  <a href="{{route('guru.index-ulangan')}}" class="breadcrumb-item">Entry Nilai Siswa</a>
  <li class="breadcrumb-item active">Indikator {{$tipe}}</li>
@endsection
@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
          @if($tipe != "Keterampilan")
              <a href="{{ route('guru.show-indikator', Crypt::encrypt(['id'=>$kelas->id, 'tipe'=>1])) }}" class="btn btn-default text-dark">
                  <i class="fas fa-exchange-alt text-dark"></i> &nbsp;
                  Entry Indikator Keterampilan
              </a>
          @else
              <a href="{{ route('guru.show-indikator', Crypt::encrypt(['id'=>$kelas->id, 'tipe'=>0])) }}" class="btn btn-default text-dark">
                  <i class="fas fa-exchange-alt text-dark"></i> &nbsp;
                  Entry Indikator Pengetahuan
              </a>
          @endif

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
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Siswa</th>
                            @foreach($indikators as $key => $indikator)
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
                                                <i class="fas fa-info-circle fa-2x text-gray"></i> &nbsp;&nbsp;
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
                            <th>
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswa as $siswaKey => $siswa)
                            <tr>
                                <td>{{ $siswaKey+1 }}</td>
                                <td>{{ $siswa->nama_siswa }}</td>
                                @foreach($indikators as $indikatorKey => $indikator)
                                <?php
                                    $nilai = "";
                                    $data_nilai = $indikator->nilai($siswa->id);
                                    if (count($data_nilai) > 0) {
                                        $nilai = $data_nilai[0]->nilai_indikator;
                                    }
                                ?>
                                <td>
                                    <form action="{{ route('guru.input-nilai-indikator') }}" method="post" autocomplete="off">
                                        @csrf
                                        <input type="hidden" id="{{"siswa_id_".$siswa->id."_".$indikator->id}}" name="siswa_id" value="{{ $siswa->id }}">
                                        <input type="hidden" id="{{"indikator_id_".$siswa->id."_".$indikator->id}}" name="indikator_id" value="{{ $indikator->id }}">
                                        <div class="input-group input-group-sm">
                                            <input type="text" id="{{"nilai_indikator_".$siswa->id."_".$indikator->id}}" class="form-control" name="nilai_indikator" value="{{$nilai}}">
                                        </div>
                                    </form>
                                </td>
                                @endforeach
                                <td>
                                    <button class="btn btn-default btn-sm form-control form-control-sm"
                                            onclick="bulkSave('{{$siswa->id}}')">
                                        <i class="fas fa fa-save"></i> &nbsp;
                                        Simpan Semua
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

        function bulkSave(siswaId) {
            const indikators = {!! json_encode($indikators) !!};
            var data = [];
            $.each(indikators, function(key, indikator) {
                var item = {
                    'siswa_id': siswaId,
                    'indikator_id': $("#indikator_id_"+siswaId+"_"+indikator.id).val(),
                    'nilai_indikator': $("#nilai_indikator_"+siswaId+"_"+indikator.id).val(),
                }
                data.push(item);
            })
            $.ajax({
                url: "{{ route('guru.bulk-input-nilai-indikator') }}",
                type: "POST",
                dataType: "JSON",
                data: {
                    _token: "{{ csrf_token() }}",
                    items: data,
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