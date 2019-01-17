<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class reservaCorrecta extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $apellidos;
    public $teatro;
    public $dia;
    public $sesion;
    public $num_butacas;
    public $listado_butacas;
    public $email;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre,$apellidos,$teatro,$dia,$sesion,$num_butacas,$listado_butacas,$email)
    {

        $this->nombre=$nombre;
        $this->apellidos=$apellidos;
        $this->teatro=$teatro;
        $this->dia=$dia;
        $this->sesion=$sesion;
        $this->num_butacas=$num_butacas;

        $listado_butacas=explode(",", $listado_butacas);
        $this->listado_butacas="";
        for($i=0;$i<count($listado_butacas);$i++){
            $butaca_coord=$listado_butacas[$i];
            $aux=explode("_", $butaca_coord);
            $fila=$aux[0];
            $columna=$aux[1];

            $this->listado_butacas.="Butaca: Fila ".$fila." , Columna ".$columna."; ";

        }

        $this->email=$email;

        $this->subject='Reserva Correcta';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.reservaCorrecta');
    }
}

