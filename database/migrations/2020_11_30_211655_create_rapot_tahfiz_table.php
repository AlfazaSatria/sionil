<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRapotTahfizTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rapot_tahfiz', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('indikator_id');
            $table->double('nilai_indikator');
            $table->bigInteger('siswa_id');
            $table->double('membaca');
            $table->double('mendengarkan');
            $table->double('mengikuti');
            $table->double('menghafal');
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
        Schema::dropIfExists('rapot_tahfiz');
    }
}
