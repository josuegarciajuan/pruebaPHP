<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sesiones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sesiones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_obra');
            $table->timestamp('inicio')->nullable();
        });


        Schema::table('reservas', function($table) {
            $table->foreign('sesion_id')
              ->references('id')->on('sesiones')
              ->onDelete('cascade'); 
        });
        Schema::table('butacas', function($table) {
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('sesiones');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
