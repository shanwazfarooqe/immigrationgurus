<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <meta name="description" content="Bootstrap Admin App + jQuery">
   <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
   <title>{{ config('app.name', 'Laravel') }}</title>
   <!-- =============== VENDOR STYLES ===============-->
   <link rel="shortcut icon" href="{{ asset('img/fav.png') }}">
   <!-- FONT AWESOME-->
   <link rel="stylesheet" href="{{ asset('css/fontawesome/css/font-awesome.min.css') }}">
   <!-- SIMPLE LINE ICONS-->
   <link rel="stylesheet" href="{{ asset('css/simple-line-icons/css/simple-line-icons.css') }}">
   
   <!-- =============== BOOTSTRAP STYLES ===============-->
   <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}" id="bscss">
   <!-- =============== APP STYLES ===============-->
   <link rel="stylesheet" href="{{ asset('css/app.css') }}" id="maincss">
    <!-- =============== custom ===============-->
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <!-- =============== sweetalert ===============-->
  <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}" id="maincss">
</head>

<body >
   <div class="wrapper">
       <div class="container">
          <a href="#">
                  <img src="{{ asset('img/logo-l.png') }}" alt="Image" class="logo-img"/>
               </a>
       </div>
   <div class="container">
     <div class="row">
       <div class="col-sm-6">
        <div class="caption-login">
         <h1>Lorem Ipsum Is Simply Dummy Text Of The</h1>
       </div>
       </div>
        <div class="col-sm-6">
          @yield('content')
        </div>
        </div>
     </div>
   </div>
   </div>

    <script src="{{ asset('js/jquery.js') }}"></script>
    <!-- =============== Sweet Alert ===============-->
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <!-- Notify -->
    <script src="{{ asset('js/notify.min.js') }}"></script>
    <script>
      @if (session('status'))
        $.notify("{{ session('status') }}", "success");
      @endif

      @if ($errors->any())
        // swal('Warning','{{ $errors->all()[0] }}','warning');
      @endif
    </script>

    @yield('custom_js')

</body>

</html>