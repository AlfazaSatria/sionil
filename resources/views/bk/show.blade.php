@extends('template_backend.home')
<?php
    $title = "Entry Nilai Affective ";
?>
@section('heading', $title)
@section('page')
<li class="breadcrumb-item ">Entry Nilai</li>
<li class="breadcrumb-item active">Affective</li>
@endsection
@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-body">
            <div class="row">

            <div class="col-md-12">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Siswa</th>
                            <th>Spiritual</th>
                            <th>Social</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswa as $key => $siswa)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $siswa->nama_siswa }}</td>
                            
                            <?php
                                $spiritual="";
                                $social="";

                                $affective = \App\Affective::where([
                                        'siswa_id' => $siswa->id,
                                        
                                    ])->get()->first();
                                    if ($affective) {
                                        $spiritual = $affective->spiritual;
                                        $social = $affective->social;
                                    }
                                ?>

                            <form action="{{ route('bk.input_nilai') }}" method="post" class="input-group">
                                @csrf
                                <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                                <td>
                                    <div class="input-group mb-3">
                                        <select class="custom-select" id="inputGroupSelect01" name="spiritual">
                                          <option selected value="{{$spiritual}}">{{$spiritual}}</option>
                                          <option value="A">A</option>
                                          <option value="B">B</option>
                                          <option value="C">C</option>
                                          <option value="D">D</option>
                                        </select>
                                      </div>
                                </td>
                                <td>
                                    <div class="input-group mb-3">
                                        <select class="custom-select" id="inputGroupSelect01" name="social">
                                          <option selected value="{{$social}}">{{$social}}</option>
                                          <option value="A">A</option>
                                          <option value="B">B</option>
                                          <option value="C">C</option>
                                          <option value="D">D</option>
                                        </select>
                                      </div>
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
    $("#liNilaiRapotGuru").addClass("menu-open");
        $("#EkstrakulikulerGuru").addClass("active");
</script>
@endsection