<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarif', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->integer('jenis_tarif_id');
            $table->enum('kelas', ['I', 'II', 'III', 'VIP', 'VVIP'])->nullable();
            $table->double('tarif', 0, 0);
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
        Schema::dropIfExists('tarif');
    }
}
