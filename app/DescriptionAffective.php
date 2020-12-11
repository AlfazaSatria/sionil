<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DescriptionAffective extends Model
{
    protected $table = 'description_affective';

    protected $fillable = [
        'deskripsi_a',
        'deskripsi_b',
        'deskripsi_c',
        'deskripsi_d'
    ];
}
