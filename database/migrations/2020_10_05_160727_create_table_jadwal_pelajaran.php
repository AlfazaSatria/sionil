<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableJadwalPelajaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_pelajaran', function(Blueprint $table){
            $table->increments('id');
            $table->string('hari');
            $table->string('kode_mp');
            $table->string('kode_guru');
            $table->string('kode_kelas');
            $table->string('kode_ruangan');
            $table->string('kode_tahun_akademik');
            $table->integer('semester');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
