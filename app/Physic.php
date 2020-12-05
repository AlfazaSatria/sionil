<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Physic extends Model
{
    protected $table= 'physical';

    protected $fillable=[
        'siswa_id',
        'height',
        'weight',
        'sem1',
        'sem2',
        'score'
    ];
}
