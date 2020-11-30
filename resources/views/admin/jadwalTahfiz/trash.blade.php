@extends('template_backend.home')
@section('heading', 'Trash Jadwal Tahfiz')
@section('page')
  <li class="breadcrumb-item active">Trash Jadwal Tahfiz</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Trash Data Jawdal</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Hari</th>
                    <th>Jadwal</th>
                    <th>Kelas</th>
                    <th>Jam Pelajaran</th>
                    <th>Ruang Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwalTahfiz as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->hari->nama_hari }}</td>
                    <td>
                        <h5 class="card-title">{{ $data->mapel->nama_mapel }}</h5>
                        <p class="card-text"><small class="text-muted">{{ $data->tahfiz->nama_tahfiz }}</small></p>
                    </td>
                    <td>{{ $data->kelas->nama_kelas }}</td>
                    <td>{{ $data->jam_mulai }} - {{ $data->jam_selesai }}</td>
                    <td>{{ $data->ruang->nama_ruang }}</td>
                    <td>
                        <form action="{{ route('jadwalTahfiz.kill', $data->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <a href="{{ route('jadwalTahfiz.restore', Crypt::encrypt($data->id)) }}" class="btn btn-success btn-sm mt-2"><i class="nav-icon fas fa-undo"></i> &nbsp; Restore</a>
                            <button class="btn btn-danger btn-sm mt-2"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $("#ViewTrash").addClass("active");
        $("#liViewTrash").addClass("menu-open");
        $("#TrashJadwalTahfiz").addClass("active");
    </script>
@endsection