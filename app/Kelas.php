<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use SoftDeletes;

    protected $fillable = [ 'nama_kelas', 'guru_id'];

    public function guru()
    {
        return $this->belongsTo('App\Guru')->withDefault();
    }

    

    protected $table = 'kelas';

    public function nilaitahfiz(){
        return $this->hasMany('App\NilaiTahfiz');
    }

    public function ulangan()
    {
        return $this->hasMany('App\Ulangan', 'kelas_id');
    }

    public function siswa()
    {
        return $this->hasMany('App\Siswa', 'kelas_id');
    }
}
