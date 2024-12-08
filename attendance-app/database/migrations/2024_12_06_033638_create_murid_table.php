<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMuridTable extends Migration
{
    public function up()
    {
        Schema::create('murid', function (Blueprint $table) {
            $table->id('id_murid');
            $table->string('nama', 100);
            $table->unsignedBigInteger('kelas_id');
            $table->timestamps();

            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('murid');
    }
}