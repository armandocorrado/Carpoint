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
        Schema::create('logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user', 60);
            $table->timestamp('date_in')->nullable();
            $table->timestamp('date_out')->nullable();
            $table->char('ip', 20)->nullable();
            $table->string('city', 45)->nullable();
            $table->string('region', 45)->nullable();
            $table->string('country', 45)->nullable();
            $table->string('longitude', 45)->nullable();
            $table->string('latitude', 45)->nullable();
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
        Schema::dropIfExists('logs');
    }
};
