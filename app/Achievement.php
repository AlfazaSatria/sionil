<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $table='achievement';

    protected $fillable=[
        'siswa_id',
        'mapel_id',
        'name',
        'description'
    ];
}
