<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sesion;
use Carbon\Carbon;

class IndexController extends Controller
{
    public function __construct() {
        
    }
    /**
     * Display the the index form parsing the needed data
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

    	$data["obras"]=Sesion::where("inicio",">",Carbon::now())->distinct()->get(['nombre_obra']);
    	$data["proxima_obra"]=Sesion::where("inicio",">",Carbon::now())->orderBy("inicio","asc")->first();

		$proximaObraFecha=Carbon::parse($data["proxima_obra"]->inicio)->format('Y-m-d');
		$data["sesiones_proximas"] = 
		Sesion::where("inicio",">",$proximaObraFecha." 00:00:00")->
				where("inicio","<",$proximaObraFecha." 23:59:00")->
				where("nombre_obra",$data["proxima_obra"]->nombre_obra)
				->orderBy("inicio","asc")
				->get();

    	
    	//dd($data);
        return view('index', $data);
    }
}
