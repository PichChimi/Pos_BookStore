<!DOCTYPE html>
<html lang="en">
   
<head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <meta content="Codescandy" name="author" />
      <title> @yield('title') </title>
      @include('includes.style')
   </head>

   <body>
      <!-- navbar -->
      @include('includes.backendScript')
     
      @yield('content')
    

      <!-- Javascript-->
      @include('includes.script')
   </body>

</html>
