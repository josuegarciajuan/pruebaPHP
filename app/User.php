<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'surname'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return user_id integer or show errors in preview view
     */
    public function store(Request $request)
    {

      $rules = [
        'name'=>'required',
        'surname'=>'required',
        'email'=>'required|email',
      ];

      $messages = [
        'name.required' => 'El nombre es obligatio.',
        'surname.required' => 'Los apellidos son obligatio.',
        'email.required' => 'El email es obligatio.',
        'email.email' => 'El email no tiene un formato adecuado.',

      ];

      $request->validate($rules, $messages);

      $user = new User([
        'name' => $request->name,
        'surname'=> $request->surname,
        'email'=> $request->email
      ]);
      $user->save();
      return $user;
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateData(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyData($id)
    {
        //
    }




    public function reserva() {
        return $this->hasOne('App\Reserva', 'user_id');
    }
}
