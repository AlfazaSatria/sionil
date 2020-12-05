<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUlanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ulangan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('siswa_id');
            $table->integer('kelas_id');
            $table->integer('guru_id');
            $table->integer('mapel_id');
            $table->double('uts')->nullable();
            $table->boolean('tipe_uts')->nullable();
            $table->double('uas')->nullable();
            $table->double('tipe_uas')->nullable();
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
        Schema::dropIfExists('ulangan');
    }
}
