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
        Schema::create('trovatas', function (Blueprint $table) {
            $table->increments('id');
            $table->char('nuovo_usato', 2)->nullable();
            $table->integer('idveicolo')->nullable();
            $table->integer('trovata')->nullable();
            $table->integer('id_operatore')->nullable();
            $table->string('user_operatore', 255)->nullable();
            $table->dateTime('dataOra')->nullable();
            $table->string('luogo', 255)->nullable();
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
        Schema::dropIfExists('trovatas');
    }
};
