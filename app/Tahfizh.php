<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tahfizh extends Model
{
    protected $guard = 'tahfizh';
    protected $table='tahfizh';
    protected $fillable=['nign','nama_tahfizh','email','password','no_hp','kode_kelas'];

    protected $primaryKey='kode_tahfizh';
     public $incrementing =false;
}
