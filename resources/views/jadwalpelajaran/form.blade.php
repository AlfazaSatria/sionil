<div class="form-group row">
    <label class="col-md-2 col-form-label text-md-right">kelas</label>
    <div class="col-md-8">
            {{ Form::select('kode_kelas',$kelas,null,['class'=>'form-control'])}}
            {{ Form::hidden('kode_tahun_akademik',$tahun_akademik->kode_tahun_akademik)}}
    </div>
</div>

<div class="form-group row">
    <label class="col-md-2 col-form-label text-md-right">Semester</label>
    <div class="col-md-8">
            {{ Form::select('semester',['1'=>'Semester 1','2'=>'Semester 2','3'=>'Semester 3','4'=>'Semester 4','5'=>'Semester 5','6'=>'Semester 6','7'=>'Semester 7','8'=>'Semester 8'],null,['class'=>'form-control'])}}
    </div>
</div>

<div class="form-group row">
        <label class="col-md-2 col-form-label text-md-right">mata pelajaran</label>
        <div class="col-md-8">
                {{ Form::select('kode_mp',$matapelajaran,null,['class'=>'form-control'])}}
        </div>
</div>
<div class="form-group row">
        <label class="col-md-2 col-form-label text-md-right">guru</label>
        <div class="col-md-8">
                {{ Form::select('kode_guru',$guru,null,['class'=>'form-control'])}}
        </div>
</div>

<div class="form-group row">
        <label class="col-md-2 col-form-label text-md-right">Ruangan</label>
        <div class="col-md-8">
                {{ Form::select('kode_ruangan',$ruangan,null,['class'=>'form-control'])}}
        </div>
</div>

<div class="form-group row">
        <label class="col-md-2 col-form-label text-md-right">Hari Dan Jam</label>
        <div class="col-md-2">
                {{ Form::select('hari',$hari,null,['class'=>'form-control'])}}
        </div>
        <div class="col-md-3">
                {{ Form::select('jam',$jampelajaran,null,['class'=>'form-control'])}}
        </div>
</div>