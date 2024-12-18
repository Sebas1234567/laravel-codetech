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
      <title>Login | CodeTechEvolution</title>
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
      <div class="bg-light min-vh-100 d-flex flex-row align-items-center dark:bg-transparent">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <div class="card-group d-block d-md-flex row">
                <div class="card col-md-7 p-4 mb-0">
                  <div class="card-body">
                    <h1>Login</h1>
                    <p class="text-medium-emphasis">Inicia sesión en tu cuenta</p>
                    <form method="POST" action="{{ route('login') }}">
                      @csrf
                      <div class="input-group mb-3">
                        <span class="input-group-text">
                          <i class="fa-duotone fa-envelope-open-text icon"></i>
                        </span>
                        <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                      <div class="input-group mb-4">
                        <span class="input-group-text">
                          <i class="fa-duotone fa-lock-keyhole icon"></i>
                        </span>
                        <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" placeholder="Password" name="password" required autocomplete="current-password">
                        @error('password')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                      <div class="row">
                        <div class="col-6">
                          <button class="btn btn-primary px-4" type="submit">Login</button>
                        </div>
                        <div class="col-6 text-end">
                          <a class="btn btn-link px-0" href="/admin/password/reset/">Olvidaste tu contraseña?</a>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="card col-md-5 text-white bg-primary py-5">
                  <div class="card-body text-center">
                    <div>
                      <h2>Administración</h2>
                      <p>Bienvenido al sitio de administración de CodeTech aqui podrás  realizar operaciones de usuarios, productos, posts, cursos y mas.</p>
                      <button class="btn btn-lg btn-outline-light mt-3" type="button">Ver Web</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- CoreUI and necessary plugins-->
      <script src="{{ asset('admin/vendors/@coreui/coreui-pro/js/coreui.bundle.min.js') }}"></script>
      <script src="{{ asset('admin/vendors/simplebar/js/simplebar.min.js') }}"></script>
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