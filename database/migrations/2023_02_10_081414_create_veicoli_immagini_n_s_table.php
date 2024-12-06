<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veicoli_immagini_n_s', function (Blueprint $table) {
            $table->increments('id_immagine');
            $table->integer('id_veicolo')->nullable();
            $table->longText('path_immagine');
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
        Schema::dropIfExists('veicoli_immagini_n_s');
    }
};
