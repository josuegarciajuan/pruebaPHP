<?php

use Illuminate\Database\Seeder;
use App\Sesion;
use App\Reserva;
use App\User;
use App\Butaca;

class AlgunosDatosParaTests extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	/*Usuarios*/
        $user=new User([
        		'id' => 1,
                'name' => "Pepe",
                'surname' => "Palotes",
                'email' => "pepe@test.com",
                
        ]);
        $user->save();
        $user=new User([
        		'id' => 2,
                'name' => "Maria",
                'surname' => "Garcia",
                'email' => "maria@test.com",
                
        ]);
        $user->save();


        /*resrva + butacas*/
        $reserva=new Reserva([
        		'id' => 1,
                'sesion_id' => 1,
                'user_id' => 1,
                'num_butacas' => 3,
        ]);
        $reserva->save();
        $butaca=new Butaca([
                'reserva_id' => 1,
                'fila' => 1,
                'columna' => 3,
        ]);
        $butaca->save();
        $butaca=new Butaca([
                'reserva_id' => 1,
                'fila' => 1,
                'columna' => 4,
        ]);
        $butaca->save();
        $butaca=new Butaca([
                'reserva_id' => 1,
                'fila' => 1,
                'columna' => 5,
        ]);
        $butaca->save();


        /*resrva + butacas*/
        $reserva=new Reserva([
        		'id' => 2,
                'sesion_id' => 1,
                'user_id' => 2,
                'num_butacas' => 2,
        ]);
        $reserva->save();
        $butaca=new Butaca([
                'reserva_id' => 2,
                'fila' => 2,
                'columna' => 1,
        ]);
        $butaca->save();
        $butaca=new Butaca([
                'reserva_id' => 2,
                'fila' => 2,
                'columna' => 2,
        ]);
        $butaca->save();


        /*butacas bloqueadas*/
        $butaca=new Butaca([
                'sesion_id' => 1,
                'fila' => 3,
                'columna' => 1,
        ]);
        $butaca->save();
        $butaca=new Butaca([
                'sesion_id' => 9,
                'fila' => 3,
                'columna' => 2,
        ]);
        $butaca->save();

    }
}
