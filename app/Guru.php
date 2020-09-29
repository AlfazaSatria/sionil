<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table=('guru');
    protected $fillable=['nign','nama_guru','email','no_hp','kode_jenjang'];

    protected $primaryKey = "kode_guru";

    public $incrementing = false;
}
