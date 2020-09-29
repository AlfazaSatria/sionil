<div class="form-group row">
    <label class="col-md-2 col-form-label text-md-right">Kode Guru</label>
    <div class="col-md-8">
        {{ Form::text('kode_guru',null,['class'=>'form-control','placeholder'=>'Kode Guru'])}}
    </div>
</div>

<div class="form-group row">
        <label class="col-md-2 col-form-label text-md-right">Nama Guru</label>
        <div class="col-md-8">
            {{ Form::text('nama_guru',null,['class'=>'form-control','placeholder'=>'Nama Guru'])}}
        </div>
</div>
<div class="form-group row">
        <label class="col-md-2 col-form-label text-md-right">Jenjang</label>
        <div class="col-md-8">
            {{ Form::select('kode_jenjang',$fakultas,null,['class'=>'form-control'])}}
        </div>
</div>

<div class="form-group row">
        <label class="col-md-2 col-form-label text-md-right">No HP</label>
        <div class="col-md-4">
            {{ Form::text('no_hp',null,['class'=>'form-control','placeholder'=>'No Hp'])}}
        </div>
    </div>

    
<div class="form-group row">
        <label class="col-md-2 col-form-label text-md-right">Email</label>
        <div class="col-md-4">
            {{ Form::email('email',null,['class'=>'form-control','placeholder'=>'Email'])}}
        </div>
</div>

<div class="form-group row">
    <label class="col-md-2 col-form-label text-md-right">Password</label>
    <div class="col-md-4">
        {{ Form::password('password',['class'=>'form-control','placeholder'=>'Password'])}}
    </div>
</div>

