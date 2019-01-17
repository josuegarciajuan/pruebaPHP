<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sesion;
use App\Reserva;
use App\Butaca;
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
		$ProximaObraMes=Carbon::parse($data["proxima_obra"]->inicio)->format('m');
		$ProximaObraAnyo=Carbon::parse($data["proxima_obra"]->inicio)->format('Y');
		$ProximaObraNombre=$data["proxima_obra"]->nombre_obra;


		$data["sesiones_proximas"] = 
		Sesion::where("inicio",">",$proximaObraFecha." 00:00:00")->
				where("inicio","<",$proximaObraFecha." 23:59:00")->
				where("nombre_obra",$data["proxima_obra"]->nombre_obra)
				->orderBy("inicio","asc")
				->get();



		//las butacas reservadas de las sesiones
		$reservas=Reserva::whereHas('sesion', function ($query) use ($ProximaObraNombre,$ProximaObraMes,$ProximaObraAnyo) {
    		$query->where('nombre_obra', $ProximaObraNombre);
    		$query->where("inicio",">=","01-".$ProximaObraMes."-".$ProximaObraAnyo)->where("inicio","<=","31-".$ProximaObraMes."-".$ProximaObraAnyo);
		})->get();
		//las butacas bloqueadas aun no reservadas
		$butacas=Butaca::whereHas('sesion', function ($query) use ($ProximaObraNombre,$ProximaObraMes,$ProximaObraAnyo) {
    		$query->where('nombre_obra', $ProximaObraNombre);
    		$query->where("inicio",">=","01-".$ProximaObraMes."-".$ProximaObraAnyo)->where("inicio","<=","31-".$ProximaObraMes."-".$ProximaObraAnyo);
		})->get();

		$butacas_totales=Config('constants.options.filas_sala')*Config('constants.options.columnas_sala');

		$data["butacas_ocupadas_dia"]=[];
		foreach ($reservas as $reserva) {
			$dia=Carbon::parse($reserva->sesion->inicio)->format('d');
			$dia=(int)$dia;

			if(isset($data["butacas_ocupadas_dia"][$dia])){
				$data["butacas_ocupadas_dia"][$dia]+=$reserva->num_butacas;
			}else{
				$data["butacas_ocupadas_dia"][$dia]=$reserva->num_butacas;
			}
		}
		foreach ($butacas as $butaca) {
			$dia=Carbon::parse($butaca->sesion->inicio)->format('d');
			$dia=(int)$dia;

			if(isset($data["butacas_ocupadas_dia"][$dia])){
				$data["butacas_ocupadas_dia"][$dia]++;
			}else{
				$data["butacas_ocupadas_dia"][$dia]=1;
			}
		}

		
		$data["sesiones_mes"] = 
		Sesion::where("inicio",">=","01-".$ProximaObraMes."-".$ProximaObraAnyo." 00:00:00")->
				where("inicio","<=","31-".$ProximaObraMes."-".$ProximaObraAnyo." 23:59:00")->
				where("nombre_obra",$data["proxima_obra"]->nombre_obra)
				->orderBy("inicio","asc")
				->get();

		$data["colores"]=[];
		for($i=1;$i<=31;$i++){
			$data["colores"][$i]="black";
		}
		foreach ($data["sesiones_mes"] as $sesion) {
			$dia_sesion=Carbon::parse($sesion->inicio)->format('d');
			$dia_sesion=(int)$dia_sesion;
			$data["colores"][$dia_sesion]="white";
		}
		foreach($data["butacas_ocupadas_dia"] as $dia => $cantidad){
			if($cantidad==$butacas_totales){
				$data["colores"][$dia]="red";
			}
		}
		
		$data["hoy"]=date("Y-m-d");

    	
    	//dd($data);
        return view('index', $data);
    }
}
