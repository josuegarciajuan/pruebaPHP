<div class="form-group">
  <label for="sel1">Selecciona una obra a ver:</label>
  <select class="form-control" id="select_obra" onchange="location.href='{{ url('/') }}'+'/'+this.value">
	@foreach ($obras as $obra)
		<option value="{{ $obra->nombre_obra }}" 
			@if($proxima_obra->nombre_obra==$obra->nombre_obra)
				selected
			@endif
		>{{ $obra->nombre_obra }}</option>
	@endforeach
  </select>
</div>

