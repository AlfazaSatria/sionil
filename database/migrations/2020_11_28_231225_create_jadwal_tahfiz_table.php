<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalTahfizTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_tahfiz', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('hari_id');
            $table->integer('kelas_id');
            $table->integer('mapel_id');
            $table->integer('tahfiz_id');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('ruang_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal_tahfiz');
    }
}
