<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTahunAkademik extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tahun_akademik', function (Blueprint $table) {
            $table->string('kode_tahun_akademik')->primary();
            $table->string('tahun_akademik');
            $table->integer('status');
            $table->date('tanggal_awal_sekolah');
            $table->date('tanggal_akhir_sekolah');
            $table->date('tanggal_awal_uts');
            $table->date('tanggal_akhir_uts');
            $table->date('tanggal_awal_uas');
            $table->date('tanggal_akhir_uas');
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
