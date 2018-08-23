<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasien', function (Blueprint $table) {
            $table->string('nomr', 6)->primary();
            $table->string('nama', 100);
            $table->string('tempat_lahir', 30);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', [1,2]);
            $table->text('alamat');
            $table->char('provinsi_id', 2);
            $table->char('kabupaten_id', 4);
            $table->char('kecamatan_id', 7);
            $table->char('kelurahan_id', 10);
            $table->enum('golongan_darah', ['A', 'AB', 'B', 'O']);
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
        Schema::dropIfExists('pasien');
    }
}
