<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Guru extends Authenticatable
{
    protected $guard = 'siswa';
    protected $table=('guru');
    protected $fillable=['nign','nama_guru','email','no_hp','kode_jenjang'];

    protected $primaryKey = "kode_guru";

    public $incrementing = false;
}
