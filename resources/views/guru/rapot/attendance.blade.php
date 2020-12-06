@extends('template_backend.home')
<?php
    $title = "Entry Nilai Attendance ";
?>
@section('heading', $title)
@section('page')
  <li class="breadcrumb-item ">Entry Nilai</li>
  <li class="breadcrumb-item active">Attendance</li>
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
                            <th>Sick</th>
                            <th>Permission</th>
                            <th>Absent</th>
                            <th>Late</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswa as $key => $siswa) 
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $siswa->nama_siswa }}</td>
                                
                                <?php
                                    $sick="";
                                    $permission="";
                                    $absent="";
                                    $late="";
                                    $attendance = \App\Attendance::where([
                                        'siswa_id' => $siswa->id,
                                    ])->get()->first();
                                    if ($attendance) {
                                        $sick = $attendance->sick;
                                        $permission = $attendance->permission;
                                        $absent = $attendance->absent;
                                        $late = $attendance->late;
                                    }
                                ?>
                                
                                    <form action="{{ route('guru.input-nilai-attendance') }}" method="post" class="input-group">
                                        @csrf
                                        <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <input class="form-control form-control-sm"
                                                       type="number"
                                                       name="sick"
                                                       value="{{ $sick }}"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <input class="form-control form-control-sm"
                                                       type="number"
                                                       name="permission"
                                                       value="{{ $permission }}"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <input class="form-control form-control-sm"
                                                       type="number"
                                                       name="absent"
                                                       value="{{ $absent }}"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <input class="form-control form-control-sm"
                                                       type="number"
                                                       name="late"
                                                       value="{{ $late }}"/>
                                            </div>
                                        </td>
                                        <td><div class="input-group-append">
                                            <button class="btn btn-info btn-sm" type="submit">
                                                <i class="fas fa fa-save"></i>
                                            </button>
                                        </div></td>
                                        
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
        $("#AttendanceGuru").addClass("active");
    </script>
@endsection