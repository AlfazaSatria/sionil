<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Indikator extends Model
{
    protected $fillable = [
        'id',
        'guru_id',
        'tipe',
        'indikator'
    ];
}
