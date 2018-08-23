<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendaftaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomr', 6);
            $table->string('kelas_id', 5);
            $table->integer('ruang_id');
            $table->integer('dokter_id');
            $table->integer('penjamin_id');
            $table->text('diagnosis_masuk');
            $table->text('diagnosis_keluar')->nullable();
            $table->dateTime('tanggal_masuk')->nullable();
            $table->dateTime('tanggal_keluar')->nullable();
            $table->text('resume')->nullable();
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
        Schema::dropIfExists('pendaftaran');
    }
}
