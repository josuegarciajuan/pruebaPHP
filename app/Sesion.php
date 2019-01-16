<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    protected $table = 'sesiones';
    protected $fillable = ['nombre_obra','inicio'];

    public $timestamps = false;

    
    public function reservas() {
       return $this->hasMany('App\Reserva');
    }

    public function butacas_bloqueadas() {
        return $this->hasMany('App\Butaca');
    }
}
