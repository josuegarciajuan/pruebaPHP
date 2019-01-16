<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Reservas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('sesion_id')->unsigned();
            $table->date('fecha');
            $table->integer('num_butacas')->unsigned();

            $table->timestamps();

            $table->foreign('user_id')
              ->references('id')->on('users')
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('reservas');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
