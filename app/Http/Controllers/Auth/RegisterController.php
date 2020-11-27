<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Guru;
use App\Siswa;
use App\BimbinganKonseling;
use App\Tahfiz;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if ($data['role'] == 'Guru') {
            $guru = Guru::where('id_card', $data['nomer'])->count();
            if ($guru >= 1) {
                $user = User::where('id_card', $data['nomer'])->count();
                if ($user >= 1) {
                    return Validator::make($data, [
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                        'password' => ['required', 'string', 'min:8', 'confirmed'],
                        'role' => ['required'],
                        'nomer' => ['required'],
                        'guru' => ['required'],
                    ]);
                } else {
                    return Validator::make($data, [
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                        'password' => ['required', 'string', 'min:8', 'confirmed'],
                        'role' => ['required'],
                        'nomer' => ['required'],
                    ]);
                }
            } else {
                return Validator::make($data, [
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                    'role' => ['required'],
                    'nomer' => ['required'],
                    'id_card' => ['required'],
                ]);
            }
        } elseif ($data['role'] == 'Tahfiz') {
            $tahfiz = Tahfiz::where('id_cardTahfiz', $data['nomer'])->count();
            if ($tahfiz >= 1) {
                $user = User::where('id_cardTahfiz', $data['nomer'])->count();
                if ($user >= 1) {
                    return Validator::make($data, [
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                        'password' => ['required', 'string', 'min:8', 'confirmed'],
                        'role' => ['required'],
                        'nomer' => ['required'],
                        'tahfiz' => ['required'],
                    ]);
                } else {
                    return Validator::make($data, [
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                        'password' => ['required', 'string', 'min:8', 'confirmed'],
                        'role' => ['required'],
                        'nomer' => ['required'],
                    ]);
                }
            } else {
                return Validator::make($data, [
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                    'role' => ['required'],
                    'nomer' => ['required'],
                    'id_cardTahfiz' => ['required'],
                ]);
            }
        }elseif ($data['role'] == 'BimbinganKonseling') {
            $bk = BimbinganKonseling::where('id_cardBK', $data['nomer'])->count();
            if ($bk >= 1) {
                $user = User::where('id_cardBK', $data['nomer'])->count();
                if ($user >= 1) {
                    return Validator::make($data, [
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                        'password' => ['required', 'string', 'min:8', 'confirmed'],
                        'role' => ['required'],
                        'nomer' => ['required'],
                        'bimbingankonseling' => ['required'],
                    ]);
                } else {
                    return Validator::make($data, [
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                        'password' => ['required', 'string', 'min:8', 'confirmed'],
                        'role' => ['required'],
                        'nomer' => ['required'],
                    ]);
                }
            } else {
                return Validator::make($data, [
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                    'role' => ['required'],
                    'nomer' => ['required'],
                    'id_cardBK' => ['required'],
                ]);
            }
        } elseif ($data['role'] == 'Siswa') {
            $siswa = Siswa::where('no_induk', $data['nomer'])->count();
            if ($siswa >= 1) {
                $user = User::where('no_induk', $data['nomer'])->count();
                if ($user >= 1) {
                    return Validator::make($data, [
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                        'password' => ['required', 'string', 'min:8', 'confirmed'],
                        'role' => ['required'],
                        'nomer' => ['required'],
                        'siswa' => ['required'],
                    ]);
                } else {
                    return Validator::make($data, [
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                        'password' => ['required', 'string', 'min:8', 'confirmed'],
                        'role' => ['required'],
                        'nomer' => ['required'],
                    ]);
                }
            } else {
                return Validator::make($data, [
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                    'role' => ['required'],
                    'nomer' => ['required'],
                    'no_induk' => ['required'],
                ]);
            }
        } else {
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role' => ['required'],
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if ($data['role'] == 'Guru') {
            $guruId = Guru::where('id_card', $data['nomer'])->get();
            foreach ($guruId as $val) {
                $guru = Guru::findorfail($val->id);
            }
            return User::create([
                'name' => $guru->nama_guru,
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
                'id_card' => $data['nomer'],
            ]);
        }elseif ($data['role'] == 'Tahfiz') {
            $tahfizId = Tahfiz::where('id_cardTahfiz', $data['nomer'])->get();
            foreach ($tahfizId as $val) {
                $tahfiz = Tahfiz::findorfail($val->id);
            }
            return User::create([
                'name' => $tahfiz->nama_tahfiz,
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
                'id_cardTahfiz' => $data['nomer'],
            ]);
        }elseif ($data['role'] == 'BimbinganKonseling') {
            $bkId = BimbinganKonseling::where('id_cardBK', $data['nomer'])->get();
            foreach ($bkId as $val) {
                $bk = BimbinganKonseling::findorfail($val->id);
            }
            return User::create([
                'name' => $bk->name,
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
                'id_cardBK' => $data['nomer'],
            ]);
        }  else {
            $siswaId = Siswa::where('no_induk', $data['nomer'])->get();
            foreach ($siswaId as $val) {
                $siswa = Siswa::findorfail($val->id);
            }
            return User::create([
                'name' => strtolower($siswa->nama_siswa),
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
                'no_induk' => $data['nomer'],
            ]);
        }
    }
}
