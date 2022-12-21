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
        Schema::dropIfExists('misions');
        Schema::create('misions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained();
            $table->string('description', 200);
            $table->integer('number_of_ninjas');
            $table->enum('priority', ['normal', 'urgente']);
            $table->string('payment', 50);
            $table->enum('state', ['completada', 'fallida', 'en curso', 'pendiente']);
            $table->string('finish_time', 9);
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
        Schema::dropIfExists('misions');
    }
};
