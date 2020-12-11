<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DescriptionAffective extends Model
{
    protected $table = 'description_affective';

    protected $fillable = [
        'deskripsi_a_sp',
        'deskripsi_b_sp',
        'deskripsi_c_sp',
        'deskripsi_d_sp',
        'deskripsi_a_so',
        'deskripsi_b_so',
        'deskripsi_c_so',
        'deskripsi_d_so',
    ];
}
