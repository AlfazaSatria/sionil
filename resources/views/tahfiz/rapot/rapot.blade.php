@extends('template_backend.home')
<?php
    $title = "Entry Nilai Rapot ";
?>
@section('heading', $title)
@section('page')
<li class="breadcrumb-item ">Entry Nilai</li>
<li class="breadcrumb-item active">Rapot</li>
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
                                <th>القدرة على قراءة القرآن ترتيلا (Able to read Al Quran with tartil)</th>
                                <th>القدرة على استماع قراءة المد ّرس / المد ّرسة (Able to listen to the teacher's
                                    reading)</th>
                                <th>القدرة على الاتباع بعد قراءة المد ّرس / المد ّرس(Able to repeat the teacher's
                                    tahfizh pronunciation)</th>
                                <th>القدرة على حفظ القرآن وضبطه(Able to memorize Al-Qur'an fluently)</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswa as $key => $siswa)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $siswa->nama_siswa }}</td>
                                <?php
                                    $nilai = "";
                                    $membaca="";
                                    $mendengarkan="";
                                    $mengikuti="";
                                    $menghafal="";
                                    
                                ?>
                                
                                    <form action="{{ route('tahfiz.input-nilai-rapot') }}" method="post" class="input-group">
                                        @csrf
                                        <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                                        <td> 
                                            <input type="text" class="form-control " name="membaca" value="{{$membaca}}">
                                        </td>
                                        <td>  
                                                <input type="text" class="form-control" name="mendengarkan" value="{{$mendengarkan}}">
                                        </td>
                                        <td>
                                                <input type="text" class="form-control" name="mengikuti" value="{{$mengikuti}}">
                                        </td>
                                        <td>
                                                <input type="text" class="form-control" name="menghafal"  value="{{$menghafal}}">
                                        </td>
                                        <td>
                                            <div class="input-group-append">
                                                <button class="btn btn-info btn-sm" type="submit">
                                                    <i class="fas fa fa-save"></i>
                                                </button>
                                            </div>
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
        $("#NilaiTahfiz").addClass("active");
        $("#liNilaiTahfiz").addClass("menu-open");
        $("#RapotTahfiz").addClass("active");
</script>
@endsection