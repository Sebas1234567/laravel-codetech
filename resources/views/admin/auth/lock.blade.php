<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,SCSS,HTML,RWD,Dashboard">
    <title>Bloqueo de Sesión |  CodeTechEvolution</title>
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('admin/assets/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('admin/assets/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('admin/assets/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('admin/assets/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('admin/assets/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('admin/assets/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('admin/assets/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('admin/assets/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('admin/assets/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('admin/assets/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('admin/assets/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('admin/assets/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin/assets/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('admin/assets/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('admin/assets/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="{{ asset('admin/vendors/simplebar/css/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/vendors/simplebar.css') }}">
    <!-- Main styles for this application-->
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <link href="{{ asset('admin/css/examples.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/load.css') }}">
    <style>
      .lock-avatar{
        background-color: #fff;
        border-radius: 50%;
        width: 6rem;
        height: 6rem;
        padding: 0.5rem;
      }
      .ig-lock{
        left: -8px;
      }
      .fc-lock{
        border: none;
        padding-left: 20px;
      }
      .btn-lock{
        border: none;
        background: #fff;
      }
      .fc-lock:focus{
        box-shadow: none;
      }
      .btn-lock:hover{
        background: #fff;
        border: #fff;
      }
      .mt-100{
        margin-top: 10%;
      }
      .mb-logol{
        margin-bottom: 10px;
      }
      .mb-logol img{
        width: 50%;
      }
      .lock-user{
        margin-bottom: 0;
        font-weight: 700;
        top: 20px;
        position: relative;
        left: 5px;
      }
      .help-block a{
        text-decoration: none;
      }
      .f-lock{
        margin-bottom: 0
      }
    </style>
  </head>
  <body>
    <div id="preloader" class="hide-load">
      <div class="cont-load">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
      </div>
    </div>
    <div class="bg-light min-vh-100 d-flex flex-row dark:bg-transparent">
      <div class="container mt-100">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="d-flex flex-row align-items-center justify-content-center mb-logol">
              <img src="{{ asset('admin/assets/img/logo-ai.png') }}" alt="CodeTech">
            </div>
            <div class="d-flex flex-row align-items-center justify-content-center lock-user">
              {{ Auth::user()->name }}
            </div>
            @if(session('error'))
              <div class="alert alert-danger" role="alert">
                {{ session('error') }}
              </div>
            @endif
            <div class="d-flex flex-row align-items-center justify-content-center mb-4">
              <div class="avatar avatar-xl lock-avatar">
                <img class="avatar-img" src="/storage/files/{{ Auth::user()->imagen }}" alt="{{ Auth::user()->name }}">
              </div>
              <form action="{{ route('unlock.session') }}" method="post" class="f-lock">
                @csrf
                <div class="input-group ig-lock">
                  <input class="form-control fc-lock" type="password" placeholder="Password" id="password" name="password">
                  <button class="btn btn-outline-secondary btn-lock" type="submit" id="button-addon2">
                    <i class="fa-duotone fa-arrow-right"></i>
                  </button>
                </div>
                <input type="hidden" name="url" id="url" value="{{ $url }}">
              </form>
            </div>
            <div class="help-block text-center mb-1">
              Ingresa tu contraseña para recuperar tu sesión
            </div>
            <div class="help-block text-center">
              <a href="{{ route('admin.login') }}">O inicia sesión con un usuario diferente</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('vendors/@coreui/coreui-pro/js/coreui.bundle.min.js') }}"></script>
    <script src="{{ asset('vendors/simplebar/js/simplebar.min.js') }}"></script>
    <script>
      if (document.body.classList.contains('dark-theme')) {
        var element = document.getElementById('btn-dark-theme');
        if (typeof(element) != 'undefined' && element != null) {
          document.getElementById('btn-dark-theme').checked = true;
        }
      } else {
        var element = document.getElementById('btn-light-theme');
        if (typeof(element) != 'undefined' && element != null) {
          document.getElementById('btn-light-theme').checked = true;
        }
      }

      function handleThemeChange(src) {
        var event = document.createEvent('Event');
        event.initEvent('themeChange', true, true);

        if (src.value === 'light') {
          document.body.classList.remove('dark-theme');
        }
        if (src.value === 'dark') {
          document.body.classList.add('dark-theme');
        }
        document.body.dispatchEvent(event);
      }
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        var loadingOverlay = document.getElementById('preloader');
        window.addEventListener('beforeunload', function() {
          loadingOverlay.classList.remove('hide-load');
          loadingOverlay.classList.add('show-load');
        });
        window.addEventListener('load', function() {
          loadingOverlay.classList.remove('show-load');
          loadingOverlay.classList.add('hide-load');
        });
      });
    </script>
  </body>
</html>