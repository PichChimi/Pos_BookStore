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
        <!-- navigation -->
        <div class="border-bottom shadow-sm">
         <nav class="navbar navbar-light py-2">
            <div class="container justify-content-center justify-content-lg-between">
               <a class="navbar-brand" href="../index.html">
                  <img src="../assets/images/logo/freshcart-logo.svg" alt="" class="d-inline-block align-text-top" />
               </a>
               {{-- <span class="navbar-text">
                  Already have an account?
                  <a href="login">Sign in</a>
               </span> --}}
            </div>
         </nav>
      </div>
     
      @yield('content')
    

      <!-- footer -->
       {{-- @include('includes.footer') --}}
      <!-- Javascript-->

      @include('includes.script')
   </body>

</html>
