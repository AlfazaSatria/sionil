<div class="form-group row">
    <label class="col-md-2 col-form-label text-md-right">Nama Mata Pelajaran</label>
    <div class="col-md-8">
        {{ Form::text('nama_mp',null,['class'=>'form-control','placeholder'=>'Nama Mata Pelajaran'])}}
    </div>
</div>

<div class="form-group row">
    <label class="col-md-2 col-form-label text-md-right">Jumlah Jam</label>
    <div class="col-md-2">
        {{ Form::text('jml_jam',null,['class'=>'form-control','placeholder'=>'Jumlah Jam'])}}
    </div>
</div>