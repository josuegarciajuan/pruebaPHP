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
     * llama al form principal pasandole los datos necesarios para que se cargue, se le puede pasar el nombre de la obra dsde el despleggable elegir obra
     *
     * @param  nombre_obra
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $nombre_obra=""){

    	$data=$this->carga_info($request, $nombre_obra);
    	return view('index', $data);
    }


    /**
     * pasa los datos necesarios para llamadas asincronas una vez cargado el form
     *
     * @param  request (nombre obra, mes, year)
     * @return \Illuminate\Http\Response
     */
    public function recargaCalendario(Request $request){

		$data=$this->carga_info($request, $request->nombre_obra, $request->mes, $request->year);
    	return json_encode($data);
    }


	/**
     * carga los horarios de las seiosnes para 1 dia y una obra dados
     *
     * @param  request (nombre obra, mes, year)
     * @return \Illuminate\Http\Response
     */
    public function cargaSesiones(Request $request){
    	$data["sesiones"]=$this->sesiones_proximas($request->date,$request->nombre_obra);
    	return json_encode($data);

    }


    /**
     * recopila la info necesaria para el form principal
     *
     * @param  request nombre obra, mes, year
     * @return array of data
     */
    private function carga_info(Request $request, $nombre_obra,$mes="", $year=""){
    	
    	$data["obras"]=$this->listado_obras();

    	$aux=$this->proximaObra($nombre_obra,$mes, $year);
    	$ProximaObraMes=$aux["ProximaObraMes"];
		$ProximaObraAnyo=$aux["ProximaObraAnyo"];
		$proximaObraFecha=$aux["proximaObraFecha"];
		$ProximaObraNombre=$aux["ProximaObraNombre"];
		$data["proxima_obra"]=$aux["proxima_obra"];

		$data["sesiones_proximas"]=$this->sesiones_proximas($proximaObraFecha,$data["proxima_obra"]->nombre_obra);

		$butacas_totales=Config('constants.options.filas_sala')*Config('constants.options.columnas_sala');

		$data["butacas_ocupadas_dia"]=$this->butacas_ocupadas($ProximaObraNombre,$ProximaObraMes,$ProximaObraAnyo);

		$data["sesiones_mes"] = $this->sesionesMes($ProximaObraAnyo,$ProximaObraMes,$data["proxima_obra"]->nombre_obra);
		
		$data["colores"]=$this->cargaColores($data["sesiones_mes"],$data["butacas_ocupadas_dia"],$butacas_totales);
		
		$data["hoy"]=date("Y-m-d");
		$data["hoy_mostrable"]=date("d-m-Y");
		$data["mes"]=date("m");
		$data["year"]=date("Y");

		$data["filas"]=Config('constants.options.filas_sala');
		$data["columnas"]=Config('constants.options.columnas_sala');


		//$data["salon"]=$this->cargaSalon($request->id);
    	
    	//dd($data);
        return $data;

    }


    /**
     * devuelve el listado de obras
     *
     * @param  
     * @return array of objects
     */
    private function listado_obras(){
    	return Sesion::where("inicio",">",Carbon::now())->distinct()->get(['nombre_obra']);
    }



    /**
     * dBuscamos la proxima obra, si no hauy ninguna en el mes buscado se muestra la 1º desde hoy
     *
     * @param   $nombre_obra,$mes, $year
     * @return array con info necesaria de la obra
     */
    private function proximaObra($nombre_obra,$mes, $year){

    	$return=[];

		
    	$query=Sesion::where("id",">",0);
    	if($nombre_obra!=""){
    		$query->where("nombre_obra",$nombre_obra);
    	}
    	if($mes==""){
    		$query->where("inicio",">",Carbon::now());
    	}else{
			$query->where("inicio",">",Carbon::parse($year."-".$mes."-01 00:00:00")->format('Y-m-d'));
    	}
    	$data["proxima_obra"]=$query->orderBy("inicio","asc")->first();

    	if(!$data["proxima_obra"]){
			$query=Sesion::where("id",">",0);
	    	if($nombre_obra!=""){
	    		$query->where("nombre_obra",$nombre_obra);
	    	}
	    	$query->where("inicio",">",Carbon::now());
	    	$data["proxima_obra"]=$query->orderBy("inicio","asc")->first();
	    	
	    	//cargamos el mes que se esta buscando por que la ora puede ser de 1 mes anterior, y necesitamos los colores del mes que se va a pintar
	    	$ProximaObraMes=$mes;	
	    	$ProximaObraAnyo=$year;


    	}else{
			$ProximaObraMes=Carbon::parse($data["proxima_obra"]->inicio)->format('m');
			$ProximaObraAnyo=Carbon::parse($data["proxima_obra"]->inicio)->format('Y');
    	}


		$proximaObraFecha=Carbon::parse($data["proxima_obra"]->inicio)->format('Y-m-d');
		$ProximaObraNombre=$data["proxima_obra"]->nombre_obra;


		$return["ProximaObraMes"]=$ProximaObraMes;
		$return["ProximaObraAnyo"]=$ProximaObraAnyo;
		$return["proximaObraFecha"]=$proximaObraFecha;
		$return["ProximaObraNombre"]=$ProximaObraNombre;
		$return["proxima_obra"]=$data["proxima_obra"];
		

		return $return;
    }

    /**
     * saca la sesiones del mes a analizar
     *
     * @param   $proximaObraFecha,$nombre_obra
     * @return array de objetos
     */
    private function sesiones_proximas($proximaObraFecha,$nombre_obra){
		//para el select de sesiones proximas
		return Sesion::where("inicio",">",$proximaObraFecha." 00:00:00")->
				where("inicio","<",$proximaObraFecha." 23:59:00")->
				where("nombre_obra",$nombre_obra)
				->orderBy("inicio","asc")
				->get();
    }


    /**
     * calcula las butacas ocupadas para una sesion, bien por reservadas o bien por bloqueadas
     *
     * @param   $ProximaObraNombre,$ProximaObraMes,$ProximaObraAnyo
     * @return array de objetos
     */
    private function butacas_ocupadas($ProximaObraNombre,$ProximaObraMes,$ProximaObraAnyo){
		//las butacas reservadas de las sesiones en el mes analizado
		$reservas=Reserva::whereHas('sesion', function ($query) use ($ProximaObraNombre,$ProximaObraMes,$ProximaObraAnyo) {
    		$query->where('nombre_obra', $ProximaObraNombre);
    		$query->where("inicio",">=",$ProximaObraAnyo."-".$ProximaObraMes."-01")->where("inicio","<=",$ProximaObraAnyo."-".$ProximaObraMes."-31");
		})->get();
		//las butacas bloqueadas aun no reservadas en el mes analizado
		$butacas=Butaca::whereHas('sesion', function ($query) use ($ProximaObraNombre,$ProximaObraMes,$ProximaObraAnyo) {
    		$query->where('nombre_obra', $ProximaObraNombre);
    		$query->where("inicio",">=",$ProximaObraAnyo."-".$ProximaObraMes."-01")->where("inicio","<=",$ProximaObraAnyo."-".$ProximaObraMes."-31");
		})->get();

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
		return $data["butacas_ocupadas_dia"];
    }


    /**
     * extraemos las sesiones que habran en el mes analizado
     *
     * @param   $ProximaObraAnyo,$ProximaObraMes,$nombre_obra
     * @return array de objetos
     */
    private function sesionesMes($ProximaObraAnyo,$ProximaObraMes,$nombre_obra){
    	return Sesion::where("inicio",">=",$ProximaObraAnyo."-".$ProximaObraMes."-01"." 00:00:00")->
				where("inicio","<=",$ProximaObraAnyo."-".$ProximaObraMes."-31"." 23:59:00")->
				where("nombre_obra",$nombre_obra)
				->orderBy("inicio","asc")
				->get();
    }


    /**
     * en base a las butacas ocupadas, lo transforma en un array donde cada color representará un estado
     *
     * @param   $sesiones_mes,$butacas_ocupadas_dia,$butacas_totales
     * @return array de objetos
     */
    private function cargaColores($sesiones_mes,$butacas_ocupadas_dia,$butacas_totales){
		$data["colores"]=[];
		//todo de negro ees que no hay nada
		for($i=1;$i<=31;$i++){
			$data["colores"][$i]="black";

		}
		//cargamos cuando hay sesion de blanco para que se elegible
		foreach ($sesiones_mes as $sesion) {
			$dia_sesion=Carbon::parse($sesion->inicio)->format('d');
			$dia_sesion=(int)$dia_sesion;
			$data["colores"][$dia_sesion]="white";
		}
		//si no quedan butacas, lo puintamos de red
		foreach($butacas_ocupadas_dia as $dia => $cantidad){
			if($cantidad==$butacas_totales){
				$data["colores"][$dia]="red";
			}
		}
		return $data["colores"];
    }

    /**
     * devuelve el estado de los asientos de una salon
     *
     * @param   id_sesion
     * @return array de butacas con sus estados
     */
    public function cargaSalon(Request $request){
    	$id_sesion=$request->id;
    	
    	$salon=[];

		//butacas resevadas en esa sesion  (directo el seiosn id)
		$butacas_reservadas=Butaca::whereHas('sesion', function ($query) use ($id_sesion) {
    		$query->where('sesion_id', $id_sesion);
		})->get()->toArray();
		 
		

		//butacas bloqueadas por esa sesion		(sacar las reservas con sesion_id)
		$butacas_bloqueadas=Butaca::where("sesion_id",$id_sesion)->get()->toArray();
		

		$butacas_ocupadas = array_merge($butacas_reservadas, $butacas_bloqueadas);
		
		for($i=1;$i<=Config('constants.options.filas_sala');$i++){
			for($j=1;$j<=Config('constants.options.columnas_sala');$j++){
				$ocupada="false";
				for ($b=0;$b<count($butacas_ocupadas);$b++) {
					if($butacas_ocupadas[$b]["fila"]==$i and $butacas_ocupadas[$b]["columna"]==$j){
						$ocupada="true";
					}
				}
				$salon[]=["fila"=>$i,"columna"=>$j,"ocupada"=>$ocupada];
			}
		}
//		dd($salon);


    	return json_encode($salon);

    }


    /**
     * intenta bloquear una butaca, si ya lo estaba devuelve error, si no lo esta la resertva y lanza cron para desreservarla en 10 min
     *
     * @param   request (id_sesion,fila,columna,array de butacas reservadas)
     * @return codigo que identifica q ha pasado, si se ha reservado, no o ya estaba
     */
    public function bloquear(Request $request){

    	$id_sesion=$request->id_sesion;
    	$fila=$request->fila;
    	$columna=$request->columna;
    	$butacas_reservadas=$request->reservadas;

    	$reservada="true";
    	//butacas bloqueadas
    	$butaca=Butaca::where("sesion_id",$id_sesion)->where("fila",$fila)->where("sesion_id",$columna)->first();

    	if(!$butaca){
	    	//butacas reservadas:
			$butaca=Butaca::whereHas('sesion', function ($query) use ($id_sesion,$fila,$columna) {
	    		$query->where('sesion_id', $id_sesion);
	    		$query->where('fila', $fila);
	    		$query->where('columna', $columna);
			})->first();

			if($butaca){

				if($this->compruebaSiLaReservoYo($fila,$columna,$butacas_reservadas)){
					$butaca->delete();					
					$reservada="desmarca";	
				}else{
					$reservada="false";	
				}
				

			}else{
				$butaca=new Butaca([
                'sesion_id' => $id_sesion,
                'fila' => $fila,
                'columna' => $columna,
		        ]);
		        $butaca->save();

		        //lanzar cron
			}

    	}else{
    		if($this->compruebaSiLaReservoYo($fila,$columna,$butacas_reservadas)){
				$butaca->delete();		
				$reservada="desmarca";				
			}else{
				$reservada="false";	
			}
    	}
    	return $reservada;

    }


    /**
     * comprueba si una butaca en base a su fia columa, la tengo reservada yo ya recorriendo el aray de mios reservadas
     *
     * @param   $fila,$columna,$butacas_reservadas
     * @return boolean
     */
    private function compruebaSiLaReservoYo($fila,$columna,$butacas_reservadas){
    	
    	$reservadaXmi=false;
    	if($butacas_reservadas){
	    	for($i=0;$i<count($butacas_reservadas);$i++){
	    		$aux=explode("_", $butacas_reservadas[$i]);
	    		$fila_r=$aux[0];
	    		$columna_r=$aux[1];
	    		if($fila_r==$fila and $columna_r==$columna){
	    			$reservadaXmi=true;
	    		}
	    	}
	   	}
    	return $reservadaXmi;
    }

}
