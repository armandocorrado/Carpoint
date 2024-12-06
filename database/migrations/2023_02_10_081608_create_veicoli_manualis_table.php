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
        Schema::create('veicoli_manualis', function (Blueprint $table) {
            $table->increments('id');
            $table->char('nuovo_usato', 1)->nullable();
            $table->char('status', 1)->nullable();
            $table->char('telaio', 30)->nullable();
            $table->char('targa', 10)->nullable();
            $table->char('ubicazione', 60)->nullable();
            $table->char('marca', 15)->nullable();
            $table->char('modello', 15)->nullable();
            $table->char('colore', 30)->nullable();
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
        Schema::dropIfExists('veicoli_manualis');
    }
};
