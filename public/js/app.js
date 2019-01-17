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
		
		}

	},


  })

  $('button.fc-prev-button').click(function(){
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "POST",
        url: '<?= url('/'); ?>/generateExcel/tst/tst/tst/tst/tst/tst/tst/tst',
        data: {search_id: <?= $search->id; ?>},
        success: function (datos) {
            
            
            
            
            location.href="<?= url('/'); ?>/excel/"+datos;
        }
    });


  });
  $('.fc-button-next span').click(function(){
    
  });
  $('.fc-hoy-button').click(function(){
    	
  });

});

