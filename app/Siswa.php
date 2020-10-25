<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Siswa extends Authenticatable
{
    protected $table="siswa";

    protected $fillable=['nisn','nama_siswa','email','password','kode_kelas','alamat','kode_tahun_akademik','semester_aktif','password'];

    protected $primaryKey = 'nisn';

    public $incrementing = false;
}
