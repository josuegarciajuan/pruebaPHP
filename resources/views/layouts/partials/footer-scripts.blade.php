<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/fullcalendar.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
	var colores = [
			@for ($i=1; $i<=31; $i++)
				"{{$colores[$i]}}",
			@endfor
		];
	var hoy = "{{$hoy}}";
	var mes = "{{$mes}}";
	var year = "{{$year}}";
	var mes_inicial = "{{$mes}}";
	var year_inicial = "{{$year}}";
	var url_base="{{ url('/') }}";
	var filas = "{{$filas}}";
	var columnas = "{{$columnas}}";
	var butacas_reservadas=[];

	@isset($exito)
		if("{{$exito}}"=="true"){
			alert("Reserva realizada correctamente. Le hemos mandado un email con la info de su reserva.");
		}
	@endisset

	var url_images="{{ asset('images') }}";
	
</script>


