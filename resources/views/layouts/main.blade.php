<!DOCTYPE html>
 
<html>
 
 <head>
 
   @include('layouts.partials.head')
 
 </head>
 
 <body>
   <div class="container" >
     @include('layouts.partials.header')
 
     @yield('content')
 
     @include('layouts.partials.footer')

   </div>

     @include('layouts.partials.footer-scripts')
 
 </body>
 
</html>