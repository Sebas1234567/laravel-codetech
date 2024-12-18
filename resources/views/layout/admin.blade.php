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
    <title>@yield('title')</title>
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
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('admin/assets/favicon/favicon-32x32.png') }} ">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('admin/assets/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin/assets/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('admin/assets/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('admin/assets/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    @yield('metas')
    <link rel="stylesheet" href="{{ asset('admin/vendors/simplebar/css/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/vendors/simplebar.css') }}">
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/load.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/toasts.css') }}">
    @yield('styles')
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
    <div class="sidebar sidebar-light sidebar-fixed" id="sidebar">
      <div class="sidebar-brand d-none d-md-flex">
        <svg class="sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
          <use xlink:href="{{ asset('admin/assets/brand/coreui.svg#full') }}"></use>
        </svg>
        <svg class="sidebar-brand-narrow" width="46" height="46" alt="CoreUI Logo">
          <use xlink:href="{{ asset('admin/assets/brand/coreui.svg#signet') }}"></use>
        </svg>
      </div>
      <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">
          <i class="nav-icon fa-duotone fa-objects-column"></i> Dashboard</a></li>
        <li class="nav-title">Website</li>
        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
          <i class="nav-icon fa-duotone fa-pager"></i> Blog</a>
          <ul class="nav-group-items">
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.blog.autor.index') }}"><span class="nav-icon"></span> Autores</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.blog.categoria.index') }}"><span class="nav-icon"></span> Categorías</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.blog.entradas.index') }}"><span class="nav-icon"></span> Entradas</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.blog.video.index') }}"><span class="nav-icon"></span> Videos</a></li>
          </ul>
        </li>
        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
          <i class="nav-icon fa-duotone fa-shop"></i> Tienda</a>
          <ul class="nav-group-items">
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.tienda.categoria.index') }}"><span class="nav-icon"></span> Categorías</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.tienda.descuento.index') }}"><span class="nav-icon"></span> Descuentos</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.tienda.giftcard.index') }}"><span class="nav-icon"></span> Giftcards</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.tienda.productos.index') }}"><span class="nav-icon"></span> Productos</a></li>
          </ul>
        </li>
        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
          <i class="nav-icon fa-duotone fa-school"></i> Cursos</a>
          <ul class="nav-group-items">
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.cursos.categoria.index') }}"><span class="nav-icon"></span> Categorías</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.cursos.curso.index') }}"><span class="nav-icon"></span> Cursos</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.cursos.video.index') }}"><span class="nav-icon"></span> Videos</a></li>
          </ul>
        </li>
        <li class="nav-divider"></li>
        <li class="nav-title">Administración</li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.compras.compras.index') }}">
          <i class="nav-icon fa-duotone fa-credit-card"></i> Compras</a>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.promocion.promociones.index') }}">
          <i class="nav-icon fa-duotone fa-badge-percent"></i> Promociones</a>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.mail.index') }}">
          <i class="nav-icon fa-duotone fa-envelopes"></i> Correos</a>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.usuarios.usuarios.index') }}">
          <i class="nav-icon fa-duotone fa-users"></i> Usuarios</a>
        </li>
      </ul>
      <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
    </div>
    <div class="wrapper d-flex flex-column min-vh-100 bg-light dark:bg-transparent">
      <header class="header header-sticky mb-4">
        <div class="container-fluid">
          <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <i class="icon icon-lg fa-duotone fa-bars"></i>
          </button><a class="header-brand d-md-none" href="#">
            <svg width="118" height="46" alt="CoreUI Logo">
              <use xlink:href="{{ asset('admin/assets/brand/coreui.svg#full') }}"></use>
            </svg></a>
          <ul class="header-nav d-none d-md-flex">
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.blog.entradas.index') }}">Entradas</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.tienda.productos.index') }}">Productos</a></li>
          </ul>
          <nav class="header-nav ms-auto me-4">
            <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
              <input class="btn-check" id="btn-light-theme" type="radio" name="theme-switch" autocomplete="off" value="light" onchange="handleThemeChange(this)">
              <label class="btn btn-primary" for="btn-light-theme">
                <i class="icon fa-regular fa-sun-bright" style="vertical-align: middle;"></i>
              </label>
              <input class="btn-check" id="btn-dark-theme" type="radio" name="theme-switch" autocomplete="off" value="dark" onchange="handleThemeChange(this)">
              <label class="btn btn-primary" for="btn-dark-theme">
                <i class="icon fa-regular fa-moon-stars" style="vertical-align: middle;"></i>
              </label>
            </div>
          </nav>
          <ul class="header-nav me-3">
            <li class="nav-item dropdown d-md-down-none">
              <?php $notiService = app(Code\Services\NotiService::class); ?>
              <?php $notis = $notiService->showNotis(); ?>
              <a class="nav-link" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="icon icon-lg my-1 mx-2 fa-duotone fa-bell"></i>
                <span class="badge rounded-pill position-absolute top-0 end-0 bg-warning-gradient @if($notis['totalNotis'] == 0)d-none @endif">{{ $notis['totalNotis'] }}</span>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg pt-0">
                <div class="dropdown-header bg-light dark:bg-white dark:bg-opacity-10">
                  <strong>Tienes {{ $notis['totalNotis'] }} notificaciones</strong>
                </div>
                @foreach ($notis['notis'] as $noti)
                <a class="dropdown-item" href="{{ route('admin.notis.seen', ['url' => $noti->url, 'id' => $noti->id]) }}">
                  <i class="icon me-2 {{ $noti->color }} {{ $noti->icono }}"></i> {{ $noti->descripcion }}
                </a>
                @if ($loop->iteration == 10)
                  @break
                @endif
                @endforeach
                <a class="dropdown-item text-center border-top" href="{{ route('admin.notis.index') }}"><strong>Ver todas las notificaciones</strong></a>
              </div>
            </li>
            <li class="nav-item dropdown d-md-down-none">
              <?php $mailService = app(Code\Services\MailService::class); ?>
              <?php $data = $mailService->ListNotiMessages(); ?>
              <a class="nav-link" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="icon icon-lg my-1 mx-2 fa-duotone @if($data['vistos'] == 0)fa-envelope @else fa-envelope-open @endif"></i>
                <span class="badge rounded-pill position-absolute top-0 end-0 bg-info-gradient @if($data['vistos'] == 0)d-none @endif">{{ $data['vistos'] }}</span>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg pt-0">
                <div class="dropdown-header bg-light dark:bg-white dark:bg-opacity-10">
                  <strong>Tienes {{ $data['vistos'] }} mensajes sin leer</strong>
                </div>
                @foreach ($data['correos'] as $message)
                <a class="dropdown-item" href="{{ route('admin.mail.detail', ['id' => $message['uid'],'folder'=>'INBOX']) }}">
                  <div class="message">
                    <div><small class="text-medium-emphasis">{{ $message['remite'] }}</small><small class="text-medium-emphasis float-end mt-1">{{ $message['dia'] }}</small></div>
                    <div class="text-truncate font-weight-bold">{{ $message['asunto'] }}...</div>
                    <div class="small text-medium-emphasis text-truncate">{{ $message['cuerpo'] }}...</div>
                  </div>
                </a>
                @if ($loop->iteration == 5)
                  @break
                @endif
                @endforeach
                <a class="dropdown-item text-center border-top" href="{{ route('admin.mail.index') }}"><strong>Ver todos los mensajes</strong></a>
              </div>
            </li>
          </ul>
          <ul class="header-nav me-4">
            <li class="nav-item dropdown d-flex align-items-center"><a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="avatar avatar-md"><img class="avatar-img" src="/storage/files/{{ Auth::user()->imagen }}" alt="{{ Auth::user()->name }}"></div>
              </a>
              <div class="dropdown-menu dropdown-menu-end pt-0">
                <div class="dropdown-header bg-light py-2 dark:bg-white dark:bg-opacity-10">
                  <div class="fw-semibold">Cuenta</div>
                </div>
                <a class="dropdown-item" href="#">
                  <i class="icon me-2 fa-duotone fa-bell"></i> Notificaciones<span class="badge badge-sm bg-warning-gradient ms-2 @if($notis['totalNotis'] == 0)d-none @endif">{{ $notis['totalNotis'] }}</span>
                </a>
                <a class="dropdown-item" href="{{ route('admin.mail.index') }}">
                  <i class="icon me-2 fa-duotone fa-envelope"></i> Mensajes<span class="badge badge-sm badge-sm bg-info-gradient ms-2 @if($data['vistos'] == 0)d-none @endif">{{ $data['vistos'] }}</span>
                </a>
                <div class="dropdown-header bg-light py-2 dark:bg-white dark:bg-opacity-10">
                  <div class="fw-semibold">Ajustes</div>
                </div>
                <a class="dropdown-item" href="#">
                  <i class="icon me-2 fa-duotone fa-user"></i> Perfil
                </a>
                <a class="dropdown-item" href="{{ route('admin.config') }}">
                  <i class="icon me-2 fa-duotone fa-gears"></i> Ajustes
                </a>
                <div class="dropdown-divider"></div>
                <?php
                  $currentPath = request()->path();
                ?>
                <a class="dropdown-item" href="{{ route('lock.form', ['url' => $currentPath]) }}">
                  <i class="icon me-2 fa-duotone fa-lock-keyhole"></i> Bloquear cuenta
                </a>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                  <i class="icon me-2 fa-duotone fa-right-from-bracket"></i> Cerrar sesión
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </div>
            </li>
          </ul>
        </div>
        <div class="header-divider"></div>
        <div class="container-fluid">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
              <li class="breadcrumb-item">
                <a href="#">@yield('bred1')</a>
              </li>
              <li class="breadcrumb-item active">
                <span>@yield('bred2')</span>
              </li>
            </ol>
          </nav>
        </div>
      </header>
      <div class="body flex-grow-1 px-3">
        <div class="container-lg">
          @yield('contenido')
        </div>
      </div>
      <footer class="footer">
        <div><strong>Copyright © 2022</strong><a href="https://coreui.io">CodeTech</a>. All rights reserved.</div>
        <div class="ms-auto"><strong>Version</strong> 3.2.0</div>
      </footer>
    </div>

    <ul class="notifications"></ul>

    @yield('modals')

    <script src="{{ asset('admin/vendors/@coreui/coreui-pro/js/coreui.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/@coreui/utils/js/coreui-utils.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="{{ asset('admin/js/toastc.js') }}"></script>
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
      var idleTime = 0;
      var path = window.location.pathname;
      var parametros = {
        url: path
      };
      var queryString = Object.entries(parametros).map(([key, value]) => `${key}=${encodeURIComponent(value)}`).join('&');
      $(document).ready(function () {
        var idleInterval = setInterval(timerIncrement, 60000);
        var interactionEvents = ['mousemove', 'keypress', 'click', 'scroll'];
        $(document).on(interactionEvents.join(' '), function (e) {
          idleTime = 0;
        });
        function timerIncrement() {
          idleTime++;
          if (idleTime >= 5) {
            window.location.href = '{{ route("lock.form") }}'+'?'+queryString;
          }
        }
      });
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
    @foreach ($notis['toast'] as $noti)
      <?php 
        $idcol = explode('-',$noti->color)[1];
      ?>
      @if ($noti->toast)
        @if ($idcol == 'success')
        <script>
          document.addEventListener("DOMContentLoaded", function() {
            createToast('{{ $idcol }}',{{ $noti->id }},'{{ $noti->titulo }}','{{ $noti->descripcion }}',true);
          });
        </script>
        @elseif ($idcol == 'info')
        <script>
          document.addEventListener("DOMContentLoaded", function() {
            createToast('{{ $idcol }}',{{ $noti->id }},'{{ $noti->titulo }}','{{ $noti->descripcion }}',true);
          });
        </script>
        @elseif ($idcol == 'danger')
        <script>
          document.addEventListener("DOMContentLoaded", function() {
            createToast('{{ $idcol }}',{{ $noti->id }},'{{ $noti->titulo }}','{{ $noti->descripcion }}',true);
          });
        </script>
        @endif
      @endif
    @endforeach
    @yield('scripts')    
  </body>
</html>