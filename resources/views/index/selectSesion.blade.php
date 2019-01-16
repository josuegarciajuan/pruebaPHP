<div class="form-group">
  <label for="sel1">Selecciona una sesión:</label>
  <select class="form-control">
	@foreach ($sesiones_proximas as $sesion)
		<option value="{{ $sesion->id }}" >{{ \Carbon\Carbon::parse($sesion->inicio)->format('h:i') }}</option>
	@endforeach
  </select>
</div>

