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
        Schema::create('note_veicoli_nuovis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('operatore')->nullable();
            $table->dateTime('dataNota')->nullable();
            $table->string('luogo')->nullable();
            $table->text('testo');
            $table->char('id_veicolo_nuovo', 12)->nullable();
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
        Schema::dropIfExists('note_veicoli_nuovis');
    }
};
