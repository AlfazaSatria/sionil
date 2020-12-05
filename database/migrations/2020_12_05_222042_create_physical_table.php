<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhysicalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physical', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('kelas_id');
            $table->bigInteger('siswa_id');
            $table->enum('rated_aspect',['height', 'weight']);
            $table->integer('semester');
            $table->double('score');
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
        Schema::dropIfExists('physical');
    }
}
