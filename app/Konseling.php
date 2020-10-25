<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Konseling extends Authenticatable
{
    protected $guard ='konseling';
    protected $table='konseling';
    protected $fillable=['nign','nama_konseling','email','kode_kelas','password'];

    protected $primaryKey='kode_konseling';

    public $incrementing = false;
}
