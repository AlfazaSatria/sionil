<div class="form-group row">
    <label class="col-md-2 col-form-label text-md-right">Tahun Akademik</label>
    <div class="col-md-8">
        {{ Form::text('tahun_akademik',null,['class'=>'form-control','placeholder'=>'Tahun akademik'])}}
    </div>
</div>

<div class="form-group row">
    <label class="col-md-2 col-form-label text-md-right">Status</label>
    <div class="col-md-8">
        {{ Form::select('status',['y'=>'Aktif','n'=>'Tidak Aktif'],null,['class'=>'form-control'])}}
    </div>
</div>

<div class="form-group row">
<label class="col-md-2 col-form-label text-md-right">Periode Sekolah</label>
<div class="row">
    <div class="col-md-6">
        {{ Form::date('tanggal_awal_sekolah',null,['class'=>'form-control','placeholder'=>'Tanggal Awal Sekolah'])}}
    </div>
    <div class="col-md-6">
        {{ Form::date('tanggal_akhir_sekolah',null,['class'=>'form-control','placeholder'=>'Tanggal Akhir Sekolah'])}}
    </div>
</div>
</div>

<div class="form-group row">
<label class="col-md-2 col-form-label text-md-right">Periode UTS</label>
<div class="row">
    <div class="col-md-6">
        {{ Form::date('tanggal_awal_uts',null,['class'=>'form-control','placeholder'=>'Tanggal Awal UTS'])}}
    </div>
    <div class="col-md-6">
        {{ Form::date('tanggal_akhir_uts',null,['class'=>'form-control','placeholder'=>'Tanggal Akhir UTS'])}}
    </div>
</div>
</div>

<div class="form-group row">
<label class="col-md-2 col-form-label text-md-right">Periode UAS</label>
<div class="row">
    <div class="col-md-6">
        {{ Form::date('tanggal_awal_uas',null,['class'=>'form-control','placeholder'=>'Tanggal Awal UAS'])}}
    </div>
    <div class="col-md-6">
        {{ Form::date('tanggal_akhir_uas',null,['class'=>'form-control','placeholder'=>'Tanggal Akhir UAS'])}}
    </div>
</div>
</div>