<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table='users';
    protected $fillable = [
        'name', 'email', 'password', 'role', 'no_induk', 'id_card','id_cardTahfiz','walikelas'
    ];

    public function guru($id)
    {
        $guru = Guru::where('id_card', $id)->get()->first();
        return $guru;
    }

    public function tahfiz($id)
    {
        $tahfiz = Tahfiz::where('id_cardTahfiz', $id)->first();
        return $tahfiz;
    }


    public function siswa($id)
    {
        $siswa = Siswa::where('no_induk', $id)->first();
        return $siswa;
    }

    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
