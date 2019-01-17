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
	console.log(colores)
</script>


