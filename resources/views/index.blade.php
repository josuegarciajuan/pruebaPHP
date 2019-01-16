@extends('layouts.main')

@section('content')

  <div class="row">
  	<div class="col-md-5 ">
  		<div class="container" >
  			<div class="row">
  				@include('index.selectObra')
			</div>  			
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
  			<div class="row">
  				@include('index.salon')
			</div>  			
  		</div>
    </div>
  </div>
  <div class="row">
  @include('index.formulario')
  </div>

@endsection


