<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reserva;

class ReservasController extends Controller
{
    public function __construct() {
        
    }

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
     * @param  \Illuminate\Http\Request  $request, user_id from a previous inserted user_id
     * @return reserva_id integer or show errors in preview view
     */
    public function store(Request $request,$user_id,$num_butacas)
    {
      $request->validate([
        'fecha'=>'required|date',
        'sesion_id'=>'required',
      ]);
      $reserva = new Reserva([
        'user_id' => $request->user_id,
        'sesion_id'=> $request->sesion_id,
        'fecha'=> $request->fecha,
        'num_butacas'=> $request->num_butacas
      ]);
      $reserva->save();
      return $reserva->id;
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
