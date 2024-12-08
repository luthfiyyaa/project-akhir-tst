<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPresensiTable extends Migration
{
    public function up()
    {
        Schema::create('detail_presensi', function (Blueprint $table) {
            $table->id('id_detail_presensi');
            $table->unsignedBigInteger('presensi_id'); // Mengacu pada tabel presensi
            $table->unsignedBigInteger('id_murid');    // Mengacu pada tabel murid
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha']); // Status absensi siswa
            $table->timestamps();

            $table->foreign('presensi_id')->references('id_presensi')->on('presensi')->onDelete('cascade');
            $table->foreign('id_murid')->references('id_murid')->on('murid')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_presensi');
    }
}