@extends('template_backend.home')
<?php
    $title = "Entry Nilai Health Condition ";
?>
@section('heading', $title)
@section('page')
  <li class="breadcrumb-item ">Entry Nilai</li>
  <li class="breadcrumb-item active">Health Condition</li>
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
                            
                            <th>
                                Physical Aspect
                            </th>
                            <th>
                                Description
                            </th>
                            <th>
                                Aksi
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswa as $key => $siswa) 
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $siswa->nama_siswa }}</td>
                                
                                <?php
                                    $name = "";
                                    $description="";
                                    
                                ?>
                                
                                    <form action="{{ route('guru.input-nilai-health') }}" method="post" class="input-group">
                                        @csrf
                                        <div class="form-group">
                                            
                                        <td>
                                            <textarea type="text" class="form-control" name="name" value="{{$name}}" placeholder="Name" rows="2"></textarea>
                                        </td>
                                        <td>
                                            <textarea type="text" class="form-control" name="description" value="{{$description}}" placeholder="Description" rows="2"></textarea>
                                            
                                        </td>
                                        <td>
                                            <div class="input-group-append">
                                                <button class="btn btn-info btn-sm" type="submit">
                                                    <i class="fas fa fa-save"></i>
                                                </button>
                                            </div>
                                        </td>
                                        </div>     
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
        $("#HealthGuru").addClass("active");
    </script>
@endsection