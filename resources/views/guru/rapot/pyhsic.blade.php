@extends('template_backend.home')
<?php
    $title = "Entry Nilai Physical Appearance ";
?>
@section('heading', $title)
@section('page')
  <li class="breadcrumb-item ">Entry Nilai</li>
  <li class="breadcrumb-item active">Physical Appearance</li>
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
                            <th>Weight Semester 1</th>
                            <th>Height Semester 1</th>
                            <th>Weight Semester 2</th>
                            <th>Height Semester 2</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswa as $key => $siswa) 
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $siswa->nama_siswa }}</td>
                                
                                <?php
                                    $hs1="";
                                    $hs2="";
                                    $ws1="";
                                    $ws2="";
                                   $physic = \App\Pyhsic::where([
                                       'siswa_id' => $siswa->id,
                                   ])->get()->first();
                                   if ($physic) {
                                       $hs1=$physic->height_sem1;
                                       $hs2=$physic->height_sem2;
                                       $ws1=$physic->weight_sem1;
                                       $ws2=$physic->weight_sem2;
                                   }
                                ?>
                                <form action="{{ route('guru.input-nilai-pyhsic') }}" method="post" class="input-group">
                                    @csrf
                                    <input type="hidden" name="siswa_id" value="{{ $siswa->id }}"/>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <input class="form-control form-control-sm"
                                                   type="number"
                                                   name="ws1"
                                                   value="{{ $ws1 }}"/>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <input class="form-control form-control-sm"
                                                   type="number"
                                                   name="hs1"
                                                   value="{{ $hs1 }}"/>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <input class="form-control form-control-sm"
                                                   type="number"
                                                   name="ws2"
                                                   value="{{ $ws2 }}"/>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <input class="form-control form-control-sm"
                                                   type="number"
                                                   name="hs2"
                                                   value="{{ $hs2 }}"/>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-info btn-sm" type="submit">
                                            <i class="fas fa fa-save"></i>
                                        </button>
                                    </td>
                                </form>
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
        $("#liNilaiRapotGuru").addClass("menu-open");
        $("#PyhsicGuru").addClass("active")
    </script>
@endsection