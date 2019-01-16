<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Butacas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('butacas', function (Blueprint $table) {
            $table->increments('id');
            table->integer('reserva_id')->unsigned()->nullable();
            $table->integer('sesion_id')->unsigned()->nullable();
            $table->integer('fila')->unsigned();
            $table->integer('columna')->unsigned();

            $table->timestamps();

            $table->foreign('reserva_id')
              ->references('id')->on('reservas')
              ->onDelete('cascade');
            $table->foreign('sesion_id')
              ->references('id')->on('sesiones')
              ->onDelete('cascade');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('butacas');
    }
}
