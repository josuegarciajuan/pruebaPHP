<div class="form-group">
  <label for="sel1">Selecciona una sesión para el día <span id="muestra_dia">{{ $hoy_mostrable }}</span>:</label>
  <select class="form-control" id="selectObra" onchange="cargaSala()">
	@foreach ($sesiones_proximas as $sesion)
		<option value="{{ $sesion->id }}" >{{ \Carbon\Carbon::parse($sesion->inicio)->format('H:i') }}</option>
	@endforeach
  </select>

</div>

