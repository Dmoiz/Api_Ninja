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
        Schema::dropIfExists('ninjas');
        Schema::create('ninjas', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20);
            $table->string('skills', 150);
            $table->enum('status', ['activo', 'retirado', 'fallecido', 'desertor']);
            $table->enum('rank', ['novato', 'soldado', 'veterano', 'maestro']);
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
        Schema::dropIfExists('ninjas');
    }
};
