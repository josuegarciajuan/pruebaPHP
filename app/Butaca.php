<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Butaca extends Model
{
    protected $fillable = ['reserva_id','sesion_id','fila','columna'];

    public function sesion() {
        return $this->belongsTo('App\Sesion');
    }
    public function reserva() {
        return $this->belongsTo('App\Reserva');
    }

    
    
}
