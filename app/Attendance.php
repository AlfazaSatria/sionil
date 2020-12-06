<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table='attendance';

    protected $fillable=[
        'siswa_id',
        'sick',
        'permission',
        'absent',
        'late'
    ];
}
