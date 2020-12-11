<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescriptionAffectiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('description_affective', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('deskripsi_a_sp');
            $table->text('deskripsi_b_sp');
            $table->text('deskripsi_c_sp');
            $table->text('deskripsi_d_sp');
            $table->text('deskripsi_a_so');
            $table->text('deskripsi_b_so');
            $table->text('deskripsi_c_so');
            $table->text('deskripsi_d_so');
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
        Schema::dropIfExists('description_affective');
    }
}
