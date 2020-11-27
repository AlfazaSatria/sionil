<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiTahfizTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_tahfiz', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('kelas_id');
            $table->integer('mapel_id');
            $table->integer('siswa_id');
            $table->integer('indikator_id');
            $table->string('indikator_name');
            $table->double('baris');
            $table->double('baris_salah');
            $table->double('nilai_abilities');
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
        Schema::dropIfExists('nilai_tahfiz');
    }
}
