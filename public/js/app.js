$(function() {
	//alert(prueba);
  $('#calendar').fullCalendar({
    // put your options and callbacks here
    firstDay: 1,

//silver: pasado
//azul seleccionado
//rojo no qeda
//blanco disponible
//negro no hay obra

//pasar desde el controler las obras de alguna forma qe pueda pintar los das facilemtne por color (el controller necesitara el mes y la obra)
//cada vezx qe se pulsa en next o prev o hoy repintar calendario llamando a lo anterior qe se funcionizara y tamb sera api
//al elegir una obra se recarga toda la pagina
//al elgir 1 dia si tiene libres cargo las ssesiones y butcas de la 1º sesion
//al cambiar sesion cambio butacas de sesion
	

	dayRender: function (date, cell) {

        cell.css("background-color",colores[date.format("D")-1]);

        if (moment().diff(date,'days') > 0){
            cell.css("background-color","silver");
        }

        if (date.isSame(hoy+'T00:00Z',"day")) {
            cell.css("background-color","blue");
        }

    },

	dayClick: function(date, jsEvent, view) {
		

		if (moment().diff(date,'days') <= 0 && colores[date.format("D")-1]!="black" && colores[date.format("D")-1]!="red"){

			for(var i=0;i<=31;i++){

				d=i;
				if(d<10){
					d="0"+i;
				}
				dateref=date.format('Y') + "-" + date.format('MM') + "-" + d;

				td=$("td").find("[data-date='" + dateref + "']");

				if (moment().diff(moment(dateref),'days') > 0){
		            td.css("background-color", "silver");
		            td.children().css("background-color", "silver");
		        }else{
		        	td.css("background-color", colores[i-1]);
	            	td.children().css("background-color", colores[i-1]);
		        }
			}
			
			
			td=$("td").find("[data-date='" + date.format() + "']");
			td.css("background-color", "blue");
			td.children().css("background-color", "blue");

			$("#muestra_dia").html(date.format("D-M-Y"));
			carga_sesiones(date.format());
			

		
		}

	},


  })

  cargaSala();

  $('button.fc-prev-button').click(function(){

  	mes--;
  	if(mes==0){
  		mes=12;
  		year--;
  	}
	recargaCalendario();  	
  });


  $('button.fc-next-button').click(function(){
	mes++;
  	if(mes==13){
  		mes=1;
  		year++;
  	}
  	recargaCalendario();
  });

  $('.fc-hoy-button').click(function(){
    mes=mes_inicial;
    year=year_inicial;
    recargaCalendario();
  });

  $("#btn_reservar").on("click", function(){
    if($("#the-form")[0].checkValidity()) {

    	if(butacas_reservadas.length==0){
    		alert("Elija alguna butaca");
    	}else{

	        $("#butacas_h").val(butacas_reservadas);
	        $("#id_sesion_h").val($("#selectObra").val());

	        $("#the-form").submit();

    	}

    }
    else {
        $("#the-form")[0].reportValidity();
    }

  });

  $("#the-form").on('submit', function(evt){
  	if($("#butacas_h").val()==""){
  		evt.preventDefault();  
  	}
    
  });


});


function recargaCalendario(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: url_base+'/recarga_calendario',
        data: {mes: mes,year: year, nombre_obra: $("#select_obra").val()},
        success: function (datos) {
            var obj = jQuery.parseJSON( datos );
            colores=[];
			$.each(obj.colores, function(i, item) {
			    colores.push(item);
			});
  			$('#calendar').fullCalendar('getView').dayGrid.renderGrid();

        }
    });

}

function carga_sesiones(date){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: url_base+'/carga_sesiones',
        data: {date: date, nombre_obra: $("#select_obra").val()},
        success: function (datos) {
        	//alert(datos);
            var obj = jQuery.parseJSON( datos );
            
            options="";
            primer=true;
            valor_cargaSala="";
			$.each(obj.sesiones, function(i, item) {
				vdate=item.inicio.split(" ");
				hour=vdate[1];
				vhour=hour.split(":");
				hour=vhour[0]+":"+vhour[1];
			    options+="<option value='"+item.id+"'>"+hour+"</option>";
			    if(primer){
			    	primer=false;
			    	valor_cargaSala=item.id;
			    }
			});

			$('#selectObra').html(options);
			cargaSala(valor_cargaSala);
        }
    });	
}
function cargaSala(id=0){
	butacas_reservadas=[];

	if(id==0){
		id=$('#selectObra').val();
	}

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $.ajax({
        type: "POST",
        url: url_base+'/carga_salon',
        data: {id: id},
        success: function (datos) {
        	//console.log(datos);
        	var obj = jQuery.parseJSON( datos );

        	html="<tr class='escenario'><td colspan='"+columnas+"' align='center'>Escenario</td></tr>";
        	for(i=1;i<=filas;i++){
        		html+="<tr>";
        		for(j=1;j<=columnas;j++){
        			
        			txt="<span id='"+i+"_"+j+"' onclick='bloquear("+id+","+i+","+j+")'><img class='butacas' src='"+url_images+"/azul.png'></span>";
					$.each(obj, function(w, item) {
						if(item.fila==i && item.columna==j && item.ocupada=="true"){
							txt="<img class='butacas' src='"+url_images+"/rojo.png'>";
						}	
					});
					html+="<td >"+txt+"</td>";

        		}	
        		html+="</tr>";
        	}
            $('#salon').html(html);

        }
    });	


	
}
function bloquear(id_sesion,fila,columna){
	
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: url_base+'/bloquear',
        data: {id_sesion: id_sesion,fila: fila, columna: columna, reservadas: butacas_reservadas},
        success: function (datos) {
        	//alert(datos);
        	//var obj = jQuery.parseJSON( datos );
        	//console.log(obj);

        	switch(datos){
        		case "true": //se ha reservado con exito el asiento lo paso a pintar y gardar al array
        			$("#"+fila+"_"+columna).html("<img class='butacas' src='"+url_images+"/seleccionado.png'>");
        			butacas_reservadas.push(fila+"_"+columna);
        			break;
        		case "false":  //ya estaba reservado, mensajito de alerta, y lo marco como ya reservado
        			alert("Esta butaca ha suido reservada mientras tenia la ventana abierta.");
        			$("#"+fila+"_"+columna).html("<img class='butacas' src='"+url_images+"/rojo.png'>");
        			break;	
        		case "desmarca":  //lo desmarco y lo borro de la lista
        			$("#"+fila+"_"+columna).html("<img class='butacas' src='"+url_images+"/azul.png'>");
        			for(i=0;i<butacas_reservadas.length;i++){
    					if(butacas_reservadas[i]==fila+"_"+columna){
							index = butacas_reservadas.indexOf(fila+"_"+columna);
							if (index > -1) {
							  butacas_reservadas.splice(index, 1);
							}
    					}
        			}
        			break;	
        	}

        }
    });	

}