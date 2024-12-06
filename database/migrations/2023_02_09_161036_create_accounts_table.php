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
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 60)->unique();
            $table->string('password', 20)->nullable();
            $table->enum('profilo', ['ADMIN', 'VENDITORE', 'PARTNER'])->default('PARTNER');
            $table->string('ragionesociale', 60)->nullable();
            $table->string('cognome', 45)->nullable();
            $table->string('nome', 45)->nullable();
            $table->char('cf', 18)->unique();
            $table->char('iva', 20)->nullable();
            $table->string('indirizzo', 100)->nullable();
            $table->string('cap', 10)->nullable();
            $table->string('telefono', 15)->nullable();
            $table->string('capo', 60)->nullable();
            $table->tinyInteger('attivo')->default(0);
            $table->string('visura', 100)->nullable();
            $table->string('cartaid', 100)->nullable();
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
        Schema::dropIfExists('accounts');
    }
};
