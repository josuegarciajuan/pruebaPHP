<div class="row" >
	<div class="col" ><h5>Rellena tus datos para terminar la reserva:</h5></div>
</div>
<div class="row mt-5"></div>
<form id="the-form" method="POST" action="reservar">
{{ csrf_field() }}
	<div class="row" >
	  <div class="col-md-3 ">
	    	
			<div class="form-group">
			  <label for="sel1">Nombre:</label>
		  	  <input type="text" class="form-control" id="name" name="name" placeholder="Escribe tu nombre" required="required">	
			</div>


	  </div>
	  <div class="col-md-4 ">
	    	
			<div class="form-group">
			  <label for="sel1">Apellido:</label>
		  	  <input type="text" class="form-control" id="surname" name="surname" placeholder="Escribe tus apellidos" required="required">	
			</div>


	  </div>

	  <div class="col-md-4 ">
	    	
			<div class="form-group">
			  <label for="sel1">Email:</label>
		  	  <input type="email" class="form-control" id="email" name="email" placeholder="Escribe tu email" required="required">	
		  	  <small id="emailHelp" class="form-text text-muted">Recibirás un email con la información de la reserva.</small>
			</div>


	  </div>
	  <div class="col-md-1 " class="div_btn_submit">
	    	
			<button class="btn btn-primary" id="btn_reservar">Reservar</button>


	  </div>

	</div>
	<input type="hidden" name="id_sesion_h" id="id_sesion_h" value="">
	<input type="hidden" name="butacas_h[]" id="butacas_h" value="">
	
</form>	