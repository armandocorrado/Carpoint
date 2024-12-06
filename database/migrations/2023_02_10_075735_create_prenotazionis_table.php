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
        Schema::create('prenotazionis', function (Blueprint $table) {
            $table->increments('id');
            $table->char('utente', 50)->nullable();
            $table->integer('idveicolo')->nullable();
            $table->enum('condizione', ['NUOVO', 'USATO'])->nullable();
            $table->date('data')->nullable();
            $table->text('note')->nullable();
            $table->enum('status', ['RICEVUTA', 'ACCETTATA', 'ANNULLATA'])->default('RICEVUTA')->comment('RICEVUTA=in attesa di conferma');
            $table->text('testo_email')->nullable();
            $table->text('accessori')->nullable();
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
        Schema::dropIfExists('prenotazionis');
    }
};
