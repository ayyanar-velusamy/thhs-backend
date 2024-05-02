<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/register.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/global.css') }}" rel="stylesheet" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
   
  </head>
  <body>
    <div class="main">
        @yield('content')
      <footer>
        <div class="container">
          <div class="row d-flex justify-content-center">
            <div class="content-wrapper col-xl-5 text-center">
              <a href="#">Release Notes</a>
              <p>Version 1.0</p>
              <p>Copyright © 2024-Designed by TrendHHS</p>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </body>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/jquery.validate.min.js') }}"></script> 
  <script src="{{ asset('js/validation.js') }}"></script>

<script>
  function hideToast(){
    $("#myToast").hide();
  }
  
</script>
  
  

</html>
