<div class="form-group row">
    <label class="col-md-2 col-form-label text-md-right">Nama kelas</label>
    <div class="col-md-8">
        {{ Form::text('nama_kelas',null,['class'=>'form-control','placeholder'=>'Nama kelas'])}}
    </div>
</div>

<div class="form-group row">
<label class="col-md-2 col-form-label text-md-right">jenjang</label>
<div class="col-md-8">
        {{ Form::select('kode_jenjang',$jenjang,null,['class'=>'form-control'])}}
</div>
</div>
