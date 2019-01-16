<?php

use Illuminate\Database\Seeder;
use App\Sesion;
use Carbon\Carbon;

class sesionesForTests extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$sesiones = [
    		["nombre_obra"=>"Romeo y Julieta", "inicio"=>Carbon::parse('2018-1-17 20:00:00')],
    		["nombre_obra"=>"La vida es sueño", "inicio"=>Carbon::parse('2018-1-17 22:30:00')],
    		["nombre_obra"=>"Romeo y Julieta", "inicio"=>Carbon::parse('2018-1-18 20:00:00')],
    		["nombre_obra"=>"La vida es sueño", "inicio"=>Carbon::parse('2018-1-18 22:30:00')],
    		["nombre_obra"=>"Romeo y Julieta", "inicio"=>Carbon::parse('2018-1-19 17:00:00')],
    		["nombre_obra"=>"La vida es sueño", "inicio"=>Carbon::parse('2018-1-19 20:00:00')],
    		["nombre_obra"=>"Romeo y Julieta", "inicio"=>Carbon::parse('2018-1-19 22:30:00')],
    		["nombre_obra"=>"La vida es sueño", "inicio"=>Carbon::parse('2018-1-19 01:00:00')],
    		["nombre_obra"=>"Romeo y Julieta", "inicio"=>Carbon::parse('2018-1-21 20:00:00')],
    		["nombre_obra"=>"La vida es sueño", "inicio"=>Carbon::parse('2018-1-21 22:30:00')],
    		["nombre_obra"=>"Romeo y Julieta", "inicio"=>Carbon::parse('2018-1-22 20:00:00')],
    		["nombre_obra"=>"La vida es sueño", "inicio"=>Carbon::parse('2018-1-22 22:30:00')],
    	];

    	for($i=0;$i<count($sesiones);$i++){
	        $sesion = new Sesion([
	            'nombre_obra' => $sesiones[$i]["nombre_obra"],
	            'inicio' => $sesiones[$i]["inicio"]
	        ]);
	        $sesion->save();
    	}

    }
}
