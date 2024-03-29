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

use App\Indikator;


Route::get('/welcome', function () {
  return view('welcome');
});

Route::get('/clear-cache', function () {
  Artisan::call('config:clear');
  Artisan::call('cache:clear');
  Artisan::call('config:cache');
  return 'DONE';
});

Auth::routes();
Route::get('/login/cek_email/json', 'UserController@cek_email');
Route::get('/login/cek_password/json', 'UserController@cek_password');
Route::post('/cek-email', 'UserController@email')->name('cek-email')->middleware('guest');
Route::get('/reset/password/{id}', 'UserController@password')->name('reset.password')->middleware('guest');
Route::patch('/reset/password/update/{id}', 'UserController@update_password')->name('reset.password.update')->middleware('guest');


Route::middleware(['auth'])->group(function () {
  Route::get('/', 'HomeController@index')->name('home');
  Route::get('/home', 'HomeController@index')->name('home');
  Route::get('/jadwal/sekarang', 'JadwalController@jadwalSekarang');
  Route::get('/profile', 'UserController@profile')->name('profile');
  Route::get('/pengaturan/profile', 'UserController@edit_profile')->name('pengaturan.profile');
  Route::post('/pengaturan/ubah-profile', 'UserController@ubah_profile')->name('pengaturan.ubah-profile');
  Route::get('/pengaturan/edit-foto', 'UserController@edit_foto')->name('pengaturan.edit-foto');
  Route::post('/pengaturan/ubah-foto', 'UserController@ubah_foto')->name('pengaturan.ubah-foto');
  Route::get('/pengaturan/email', 'UserController@edit_email')->name('pengaturan.email');
  Route::post('/pengaturan/ubah-email', 'UserController@ubah_email')->name('pengaturan.ubah-email');
  Route::get('/pengaturan/password', 'UserController@edit_password')->name('pengaturan.password');
  Route::post('/pengaturan/ubah-password', 'UserController@ubah_password')->name('pengaturan.ubah-password');

  Route::middleware(['siswa'])->group(function () {
    Route::get('/jadwal/siswa', 'JadwalController@siswa')->name('jadwal.siswa');
    Route::get('/ulangan/siswa', 'UlanganController@siswa')->name('ulangan.siswa');
    Route::get('/sikap/siswa', 'SikapController@siswa')->name('sikap.siswa');
    Route::get('/rapot/siswa/{tipe_rapot}', 'RapotController@siswa')->name('rapot.siswa');
  });

  Route::middleware(['guru'])
      ->prefix('/guru')
      ->group(function () {
          Route::resource('/nilai', 'NilaiController', [
              'names' => [
                  'index' => 'guru.index-nilai',
                  'store' => 'guru.store-nilai',
              ],
          ]);
          Route::resource('/ulangan', 'UlanganController', [
              'names' => [
                  'index' => 'guru.index-ulangan',
                  'show' => 'guru.show-ulangan',
                  'create' => 'guru.create-ulangan',
                  'store' => 'guru.store-ulangan',
                  'destroy' => 'guru.destroy-ulangan',
              ]
          ]);
          Route::resource('/sikap', 'SikapController', [
              'names' => [
                  'index' => 'guru.index-sikap',
                  'show' => 'guru.show-sikap',
                  'create' => 'guru.create-sikap',
                  'store' => 'guru.store-sikap',
                  'destroy' => 'guru.destroy-sikap',
              ]
          ]);
          Route::resource('/rapot', 'RapotController', [
              'names' => [
                  'index' => 'guru.index-rapot',
                  'show' => 'guru.show-rapot',
                  'store' => 'guru.store-rapot',
                  'destroy' => 'guru.destroy-rapot',
                  'predikat' => 'guru.predikat-rapot',
                  
              ]
          ]);
          Route::resource('/indikator', 'IndikatorController', [
              'names' => [
                  'index' => 'guru.index-indikator',
                  'store' => 'guru.store-indikator',
              ],
              'except' => [
                'create', 'edit', 'update',
              ],
          ]);
          Route::get('/cetak/rapot', 'RapotController@dataRapot')->name('guru.data-rapot');
          Route::get('/cetak/guru/{encryption}', 'RapotController@guru')->name('rapot.guru');
          Route::get('/ekstrakulikuler', 'RapotController@indexekstrakulikuler')->name('guru.ekstrakulikuler-rapot');
          Route::post('/ekstrakulikuler/inputnilai', 'RapotController@inputekstrakulikuler')->name('guru.input-nilai-ekstrakulikuler');
          Route::get('/health', 'RapotController@indexhealth')->name('guru.health-rapot');
          Route::post('/health/inputnilai', 'RapotController@input_health')->name('guru.input-nilai-health');
          Route::get('/achievement', 'RapotController@indexachievement')->name('guru.achievement-rapot');
          Route::post('/achievement/inputnilai', 'RapotController@input_achievement')->name('guru.input-nilai-achievement');
          Route::get('/attendance', 'RapotController@indexattendance')->name('guru.attendance-rapot');
          Route::post('/attendance/inputnilai', 'RapotController@input_attendance')->name('guru.input-nilai-attendance');
          Route::get('/pyhsic', 'RapotController@indexpyhsic')->name('guru.pyhsic-rapot');
          Route::post('/pyhsic/inputnilai', 'RapotController@input_pyhsic')->name('guru.input-nilai-pyhsic');
          Route::get('/remark', 'RapotController@indexremark')->name('guru.remark-rapot');
          Route::post('/remark/inputnilai', 'RapotController@input_remark')->name('guru.input-nilai-remark');
          Route::get('/indikator/{encryption}', 'IndikatorController@show')->name('guru.show-indikator');
          Route::post('/indikator/inputnilai', 'IndikatorController@input_nilai')->name('guru.input-nilai-indikator');
          Route::post('/indikator/bulkinputnilai', 'IndikatorController@bulk_input_nilai')->name('guru.bulk-input-nilai-indikator');
          Route::delete('/indikator/{id}', 'IndikatorController@destroy')->name('guru.destroy-indikator');
          Route::get('/jadwal', 'JadwalController@guru')->name('jadwal.guru');
  });

  Route::middleware(['tahfiz'])
      ->prefix('/tahfiz')
      ->group(function () {
          Route::resource('/indikatorTahfiz', 'IndikatorTahfizController', [
              'names' => [
                  'index' => 'tahfiz.index-indikator',
                  'store' => 'tahfiz.store-indikator',
              ],
              'except' => [
                'create', 'edit', 'update',
              ],
          ]);

          Route::resource('/data', 'DataTahfizController', [
            'names' => [
                'index' => 'tahfiz.index-data',
                'show' => 'tahfiz.show-data',
            ]
        ]);

        Route::resource('/rapot', 'RapotTahfizController', [
          'names' => [
              'index' => 'tahfiz.index-rapot',
              'show' => 'tahfiz.show-rapot',
          ]
      ]);
          Route::get('/indikatorTahfiz/{encryption}', 'IndikatorTahfizController@show')->name('tahfiz.show-indikator');
          Route::post('/indikatorTahfiz/inputnilai', 'IndikatorTahfizController@input_nilai')->name('tahfiz.input-nilai-indikator');
          Route::delete('/indikatorTahfiz/{id}', 'IndikatorTahfizController@destroy')->name('tahfiz.destroy-indikator');

          Route::get('/rapotTahfiz/{encryption}', 'RapotTahfizController@show')->name('tahfiz.show-rapot');
          Route::post('/rapotTahfiz/inputnilai', 'RapotTahfizController@input_nilai')->name('tahfiz.input-nilai-rapot');
          Route::get('/jadwalTahfiz', 'JadwalTahfizController@tahfiz')->name('jadwal.tahfiz');
          Route::get('/export_excel/{encryption}', 'RapotTahfizController@export_excel')->name('tahfiz.export_excel');
          Route::get('/datakelas', 'RapotTahfizController@datakelas')->name('tahfiz.data-kelas');
          Route::get('/datasiswa/{encryption}', 'RapotTahfizController@datasiswa')->name('tahfiz.data-siswa');
          
  });

  Route::middleware(['bimbingankonseling'])
      ->prefix('/bimbingankonseling')
      ->group(function () {

      Route::get('/index', 'BKController@index')->name('bk.index');
      Route::get('/bk/{encryption}', 'BKController@show')->name('bk.show');
      Route::post('/bk/inputnilai', 'BKController@input_nilai')->name('bk.input_nilai');  
      Route::get('/datadeskripsi', 'BKController@deskripsi')->name('bk.deskripsi');
      Route::post('/deskripsi/simpan', 'BKController@input_deskripsi')->name('bk.deskripsi.simpan'); 
  });

  
  Route::middleware(['kepsek'])->group(function () {
    Route::get('/kepsek/home', 'HomeController@admin')->name('kepsek.home');
    Route::get('/kepsek/pengumuman', 'PengumumanController@index')->name('kepsek.pengumuman');
  });

  Route::middleware(['admin'])->group(function () {
    Route::middleware(['trash'])->group(function () {
      Route::get('/jadwal/trash', 'JadwalController@trash')->name('jadwal.trash');
      Route::get('/jadwal/restore/{id}', 'JadwalController@restore')->name('jadwal.restore');
      Route::delete('/jadwal/kill/{id}', 'JadwalController@kill')->name('jadwal.kill');
      Route::get('/guru/trash', 'GuruController@trash')->name('guru.trash');
      Route::get('/guru/restore/{id}', 'GuruController@restore')->name('guru.restore');
      Route::delete('/guru/kill/{id}', 'GuruController@kill')->name('guru.kill');
      Route::get('/kelas/trash', 'KelasController@trash')->name('kelas.trash');
      Route::get('/kelas/restore/{id}', 'KelasController@restore')->name('kelas.restore');
      Route::delete('/kelas/kill/{id}', 'KelasController@kill')->name('kelas.kill');
      Route::get('/siswa/trash', 'SiswaController@trash')->name('siswa.trash');
      Route::get('/siswa/restore/{id}', 'SiswaController@restore')->name('siswa.restore');
      Route::delete('/siswa/kill/{id}', 'SiswaController@kill')->name('siswa.kill');
      Route::get('/mapel/trash', 'MapelController@trash')->name('mapel.trash');
      Route::get('/mapel/restore/{id}', 'MapelController@restore')->name('mapel.restore');
      Route::delete('/mapel/kill/{id}', 'MapelController@kill')->name('mapel.kill');
      Route::get('/user/trash', 'UserController@trash')->name('user.trash');
      Route::get('/user/restore/{id}', 'UserController@restore')->name('user.restore');
      Route::delete('/user/kill/{id}', 'UserController@kill')->name('user.kill');
      Route::get('/backup', 'DatabaseController@our_backup_database')->name('backup_database');

      

    });
    Route::get('/admin/home', 'HomeController@admin')->name('admin.home');
    Route::get('/admin/pengumuman', 'PengumumanController@index')->name('admin.pengumuman');
    Route::post('/admin/pengumuman/simpan', 'PengumumanController@simpan')->name('admin.pengumuman.simpan');
    Route::get('/admin/term', 'PengumumanController@DataTerm')->name('admin.term');
    Route::post('/admin/term/simpan', 'PengumumanController@saveTerm')->name('admin.term.simpan');
    Route::get('/guru/mapel/{id}', 'GuruController@mapel')->name('guru.mapel');
    Route::get('/guru/ubah-foto/{id}', 'GuruController@ubah_foto')->name('guru.ubah-foto');
    Route::post('/guru/update-foto/{id}', 'GuruController@update_foto')->name('guru.update-foto');
    Route::post('/guru/upload', 'GuruController@upload')->name('guru.upload');
    Route::get('/guru/export_excel', 'GuruController@export_excel')->name('guru.export_excel');
    Route::post('/guru/import_excel', 'GuruController@import_excel')->name('guru.import_excel');
    Route::delete('/guru/deleteAll', 'GuruController@deleteAll')->name('guru.deleteAll');
    Route::get('/tahfiz/mapel/{id}', 'TahfizController@mapel')->name('tahfiz.mapel');
    Route::get('/tahfiz/ubah-foto/{id}', 'TahfizController@ubah_foto')->name('tahfiz.ubah-foto');
    Route::post('/tahfiz/update-foto/{id}', 'TahfizController@update_foto')->name('tahfiz.update-foto');
    Route::delete('/tahfiz/deleteAll', 'TahfizController@deleteAll')->name('tahfiz.deleteAll');
    Route::resource('/guru', 'GuruController');
    Route::resource('/tahfiz', 'TahfizController');
    Route::get('/kelas/edit/json', 'KelasController@getEdit');
    Route::resource('/kelas', 'KelasController');
    Route::get('/siswa/kelas/{id}', 'SiswaController@kelas')->name('siswa.kelas');
    Route::get('/siswa/view/json', 'SiswaController@view');
    Route::get('/siswa/ubah-foto/{id}', 'SiswaController@ubah_foto')->name('siswa.ubah-foto');
    Route::post('/siswa/update-foto/{id}', 'SiswaController@update_foto')->name('siswa.update-foto');
    Route::get('/siswa/export_excel', 'SiswaController@export_excel')->name('siswa.export_excel');
    Route::post('/siswa/import_excel', 'SiswaController@import_excel')->name('siswa.import_excel');
    Route::delete('/siswa/deleteAll', 'SiswaController@deleteAll')->name('siswa.deleteAll');
    Route::resource('/siswa', 'SiswaController');
    
    Route::get('/mapel/getMapelJson', 'MapelController@getMapelJson');
    Route::resource('/mapel', 'MapelController');
    Route::get('/jadwal/view/json', 'JadwalController@view');
    Route::get('/jadwal/export_excel', 'JadwalController@export_excel')->name('jadwal.export_excel');
    Route::post('/jadwal/import_excel', 'JadwalController@import_excel')->name('jadwal.import_excel');
    Route::delete('/jadwal/deleteAll', 'JadwalController@deleteAll')->name('jadwal.deleteAll');
    Route::resource('/jadwal', 'JadwalController');
    Route::get('/jadwal/guru', 'JadwalController@guru')->name('jadwal.guru');

    Route::get('/jadwalTahfiz/view/json', 'JadwalTahfizController@view');
    Route::get('/jadwalTahfiz/export_excel', 'JadwalTahfizController@export_excel')->name('jadwalTahfiz.export_excel');
    Route::delete('/jadwalTahfiz/deleteAll', 'JadwalTahfizController@deleteAll')->name('jadwalTahfiz.deleteAll');
    Route::resource('/jadwalTahfiz', 'JadwalTahfizController');
    Route::get('/jadwalTahfiz/guru', 'JadwalTahfizController@guru')->name('jadwalTahfiz.tahfiz');

    Route::get('/ulangan-kelas', 'UlanganController@create')->name('ulangan-kelas');
    Route::get('/ulangan-siswa/{id}', 'UlanganController@edit')->name('ulangan-siswa');
    Route::get('/ulangan-show/{id}', 'UlanganController@ulangan')->name('ulangan-show');
    Route::get('/sikap-kelas', 'SikapController@create')->name('sikap-kelas');
    Route::get('/sikap-siswa/{id}', 'SikapController@edit')->name('sikap-siswa');
    Route::get('/sikap-show/{id}', 'SikapController@sikap')->name('sikap-show');
    Route::get('/rapot-kelas', 'RapotController@create')->name('rapot-kelas');
    Route::get('/rapot-siswa/{id}', 'RapotController@edit')->name('rapot-siswa');
    Route::get('/rapot-show/{id}', 'RapotController@rapot')->name('rapot-show');
    Route::get('/predikat', 'NilaiController@create')->name('predikat');
    Route::resource('/user', 'UserController');
    
  });
});
