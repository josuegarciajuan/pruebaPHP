<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = ['user_id','sesion_id','fecha','num_butacas'];

    public function butacas() {
        return $this->hasMany('App\Butaca');
    }

    public function sesion() {
        return $this->belongsTo('App\Sesion');
    }

    public function user() {
        return $this->hasOne('App\User');
    }
}
