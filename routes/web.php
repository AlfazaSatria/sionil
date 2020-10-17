<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/guru/login','LoginGuruController@index');
Route::post('/guru/login','LoginGuruController@submit');
Route::get('/siswa/login','LoginSiswaController@index');
Route::post('/siswa/login','LoginSiswaController@submit');

Route::group(['middleware' => ['auth:guru']], function () {
    Route::get('jadwal_mengajar','GuruController@jadwal_mengajar');
    Route::get('jadwal_mengajar/json','GuruController@jadwal_mengajar_json');
});

Auth::routes();
Route::get('/matapelajaran/json','MatapelajaranController@json');
Route::get('/guru/json','GuruController@json');
Route::get('/kelas/json','KelasController@json');
Route::get('/jenjang/json','JenjangController@json');
Route::get('/siswa/json','SiswaController@json');
Route::get('/ruangan/json','RuanganController@json');
Route::get('/tahunakademik/json','TahunAkademikController@json');
Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/matapelajaran', 'MataPelajaranController');
Route::resource('/guru','GuruController');
Route::resource('/kelas','KelasController');
Route::resource('/jenjang','JenjangController');
Route::resource('/tahunakademik','TahunAkademikController');
Route::resource('/jadwalpelajaran','JadwalpelajaranController');
Route::resource('/siswa','SiswaController');
Route::resource('/ruangan','RuanganController');

