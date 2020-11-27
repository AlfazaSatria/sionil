<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRapotTahfiz extends Migration
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
            $table->integer('nilai_tahfiz_id');
            $table->string('name_abilities');
            $table->enum('type',['hd','d','c','p','ni']);
            $table->double('nilai_abilities');
            $table->enum('rapot',['membaca','mendengarkan','mengikuti','menghafal']);
            $table->double('nilai_rapot');
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
