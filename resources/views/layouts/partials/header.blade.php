<div class="row" id="cabecera">
  <div class="col" >
    <h3>Reserva tu entrada</h3> 


  </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif