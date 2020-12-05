<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Health extends Model
{
    protected $table = 'health_condition';

    protected $fillable=[
        'siswa_id',
        'name',
        'description'
    ];
}
