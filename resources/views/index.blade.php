@extends('layouts.main')

@section('content')

  <div class="row mt-3"></div>

  <div class="row">
  	<div class="col-md-5 ">
  		<div class="container" >
  			<div class="row">
  				@include('index.selectObra')
			</div>
			<div class="row mt-3"></div>  			
  			<div class="row">
  				@include('index.calendario')
			</div>  			
  		</div>
  	</div>

    <div class="col-md-7">
  		<div class="container" >
  			<div class="row">
  				@include('index.selectSesion')
			</div>  		
			<div class="row mt-5"></div> 	
  			<div class="row">
  				@include('index.salon')
			</div>  			
  		</div>
    </div>
  </div>

  
  <hr />
  <div class="row mt-2"></div>
  <div class="row">
  @include('index.formulario')
  </div>

@endsection


