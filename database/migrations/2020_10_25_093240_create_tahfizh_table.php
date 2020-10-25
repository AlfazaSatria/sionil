<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTahfizhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tahfizh', function (Blueprint $table) {
            $table->string('nign')->primary();
            $table->string('kode_tahfizh');
            $table->string('nama_tahfizh');
            $table->string('kode_kelas');
            $table->string('no_hp');
            $table->string('email');
            $table->string('password');
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
        Schema::dropIfExists('tahfizh');
    }
}
