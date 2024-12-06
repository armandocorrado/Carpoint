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
        Schema::create('sconti_usatos', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('importo_da', 15, 3)->default(0.000);
            $table->decimal('importo_a', 15, 3)->default(0.000);
            $table->unsignedTinyInteger('percentuale')->default(0);
            $table->unsignedTinyInteger('attivo')->default(1);
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
        Schema::dropIfExists('sconti_usatos');
    }
};
