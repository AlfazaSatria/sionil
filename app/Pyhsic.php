<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pyhsic extends Model
{
    protected $table= 'physical';

    protected $fillable=[
        'siswa_id',
        'height_sem1',
        'weight_sem1',
        'height_sem1',
        'weight_sem2'
    ];
}
