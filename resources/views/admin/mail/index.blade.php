@extends('layout.mail')

@section('title'){{ $folder }} | CodeTechEvolution @stop

@section('metas')
<meta name="csrf-token" content="{{ csrf_token() }}"> 
<meta name="folder" content="{{ $folder }}">
@stop

@section('contenido')
<div class="card mb-4">
  <div class="card-body">
    <div class="btn-toolbar mb-4">
      <button class="btn btn-light me-1" type="button" id="check-button" onclick="checkCorreos();">
        <i class="fa-duotone fa-square"></i>
      </button>
      <div class="btn-group me-1 d-none" id="option-buttons">
        <button class="btn btn-light" type="button" onclick="marcarLeido();">
          @if ($vistos > 0)
            <i class="fa-duotone fa-envelope-open-text"></i>
          @else
          <i class="fa-duotone fa-envelope"></i>
          @endif
        </button>
        <button class="btn btn-light" type="button" onclick="marcarFavorito();">
          <i class="fa-regular fa-star"></i>
        </button>
        <button class="btn btn-light" type="button" onclick="marcarImportante();">
          <i class="fa-duotone fa-bookmark"></i>
        </button>
        <button class="btn btn-light" type="button" onclick="papeleraMail();">
          <i class="fa-duotone fa-trash-can"></i>
        </button>
      </div>
      <button class="btn btn-light me-1" type="button" onclick="location.reload();">
        <i class="fa-duotone fa-rotate-right"></i>
      </button>
      <div class="btn-group ms-auto">
        <a class="btn btn-light @if ($paginator->onFirstPage()) disabled @endif" href="@if ($folder == 'INBOX')
          /admin/mail{{ $paginator->previousPageUrl() }}
        @elseif ($folder == 'Enviados')
          /admin/mail/sends{{ $paginator->previousPageUrl() }}
        @elseif ($folder == 'Borradores')
          /admin/mail/drafts{{ $paginator->previousPageUrl() }}
        @elseif ($folder == 'Spam')
          /admin/mail/junks{{ $paginator->previousPageUrl() }}
        @elseif ($folder == 'Papelera')
          /admin/mail/trash{{ $paginator->previousPageUrl() }}
        @endif ">
          <i class="fa-solid fa-chevron-left"></i>
        </a>
        <a class="btn btn-light @if ($paginator->hasMorePages()) @else disabled @endif" href="@if ($folder == 'INBOX')
          /admin/mail{{ $paginator->nextPageUrl() }}
        @elseif ($folder == 'Enviados')
          /admin/mail/sends{{ $paginator->nextPageUrl() }}
        @elseif ($folder == 'Borradores')
          /admin/mail/drafts{{ $paginator->nextPageUrl() }}
        @elseif ($folder == 'Spam')
          /admin/mail/junks{{ $paginator->nextPageUrl() }}
        @elseif ($folder == 'Papelera')
          /admin/mail/trash{{ $paginator->nextPageUrl() }}
        @endif ">
          <i class="fa-solid fa-chevron-right"></i>
        </a>
      </div>
    </div>
    <div class="messages">
      @foreach ($paginator as $correo)
        <a class="message d-flex mb-3 @if ($correo['visto']) text-medium-emphasis @else text-high-emphasis @endif text-decoration-none" href="{{ route('admin.mail.detail',['folder'=>$folder,'id'=>$correo['uid']]) }}" data-uid="{{ $correo['uid'] }}">
          <div class="message-actions me-3 d-flex">
            <div class="check-select">
              <input class="form-check-input" type="checkbox" id="check{{ $correo['uid'] }}" value="{{ $correo['uid'] }}" style="margin-top: 7px;">
            </div>
            <div class="ms-2">
              <input class="form-check-input" type="checkbox" value="" id="starcheck{{ $correo['uid'] }}" name="starcheck{{ $correo['uid'] }}" hidden @if ($correo['favorito'])checked @endif onclick="Favorito(true,folder,{{ $correo['uid'] }});">
              <label class="form-check-label" for="starcheck{{ $correo['uid'] }}">
                <i class="icon @if ($correo['favorito'])fa-solid @else fa-regular @endif fa-star" @if ($correo['favorito'])style="color: #FFD43B;"@endif></i>
              </label>
            </div>
          </div>
          <div class="message-details flex-wrap pb-3 border-bottom">
            <div class="message-headers d-flex flex-wrap">
              <div class="message-headers-from">{{ $correo['remite'] }}</div>
              <div class="message-headers-date ms-auto">
                @if ($correo['adjuntos'])
                  <i class="icon fa-solid fa-paperclip"></i>
                @endif {{ $correo['dia'] }}
              </div>
              <div class="message-headers-subject w-100 fs-5 fw-semibold">{{ $correo['asunto'] }}</div>
            </div>
            <div class="message-body">{!! $correo['cuerpo'] !!}...</div>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</div>
@stop

@section('scripts')
<script>
  var csrfToken = $('meta[name="csrf-token"]').attr('content');
  var folder = $('meta[name="folder"]').attr('content');
  let checks = document.querySelectorAll('.check-select input');
  let icon = document.querySelector('#check-button i');
  let options = document.getElementById("option-buttons");
  let numcheck = 0;
  for (let check of checks) {
    check.addEventListener("change", function () {
      if (this.checked) {
        numcheck++;
        if (numcheck ==  checks.length) {
          icon.classList.remove('fa-square');
          icon.classList.add('fa-square-check');
        } else {
          icon.classList.remove('fa-square');
          icon.classList.add('fa-square-minus');
        }
        options.classList.remove('d-none');
      } else {
        numcheck--;
        if (numcheck == 0) {
          icon.classList.remove('fa-square-minus');
          icon.classList.add('fa-square');
          options.classList.add('d-none');
        } else {
          icon.classList.remove('fa-square-check');
          icon.classList.add('fa-square-minus');
        }
      }
    });
  }

  function checkCorreos(){
    if (icon.classList.contains('fa-square')) {
      for (let check of checks) {
        check.checked = true;
      }
      icon.classList.remove('fa-square');
      icon.classList.add('fa-square-check');
      options.classList.remove('d-none');
    } else if (icon.classList.contains('fa-square-check')) {
      for (let check of checks) {
        check.checked = false;
      }
      icon.classList.remove('fa-square-check');
      icon.classList.add('fa-square');
      options.classList.add('d-none');
    } else if (icon.classList.contains('fa-square-minus')) {
      for (let check of checks) {
        if (check.checked) {
          check.checked = false;
        }
      }
      icon.classList.remove('fa-square-minus');
      icon.classList.add('fa-square');
      options.classList.add('d-none');
    }
  }

  function Favorito(reload, folder, id) {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': csrfToken
      }
    });
    $.ajax({
      url: `/mail/favorite/${folder}/${id}`,
      type: 'PUT',
      success: function(response) {
        console.log('Correo marcado como favorito');
        if (reload) {
          location.reload();
        }
      },
      error: function(error) {
        console.error('Error al marcar como favorito :(', error);
      }
    });
  }

  function Leido(reload, folder, id) {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': csrfToken
      }
    });
    $.ajax({
      url: `/mail/seen/${folder}/${id}`,
      type: 'PUT',
      success: function(response) {
        console.log('Correo marcado como leido');
        if (reload) {
          location.reload();
        }
      },
      error: function(error) {
        console.error('Error al marcar como leido :(', error);
      }
    });
  }

  function Papelera(reload, folder, id) {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': csrfToken
      }
    });
    $.ajax({
      url: `/mail/trash/${folder}/${id}`,
      type: 'PUT',
      success: function(response) {
        console.log('Correo enviado a la papelera');
        if (reload) {
          location.reload();
        }
      },
      error: function(error) {
        console.error('Error al enviar correo a la papelera :(', error);
      }
    });
  }

  function Eliminar(reload, folder, id) {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': csrfToken
      }
    });
    $.ajax({
      url: `/mail/delete/${folder}/${id}`,
      type: 'PUT',
      success: function(response) {
        console.log('Correo eliminado');
        if (reload) {
          location.reload();
        }
      },
      error: function(error) {
        console.error('Error al eliminar el correo :(', error);
      }
    });
  }

  function Importante(reload, folder, id) {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': csrfToken
      }
    });
    $.ajax({
      url: `/mail/important/${folder}/${id}`,
      type: 'PUT',
      success: function(response) {
        console.log('Correo marcado como importante');
        if (reload) {
          location.reload();
        }
      },
      error: function(error) {
        console.error('Error al marcar el correo como importante :(', error);
      }
    });
  }

  function marcarFavorito() {
    for (let check of checks) {
      if (check.checked){
        Favorito(false, folder, check.value);
      }
    }
    location.reload();
  }

  function papeleraMail() {
    for (let check of checks) {
      if (check.checked){
        if (folder == 'Papelera') {
          Eliminar(false, folder, check.value);
        } else {
          Papelera(false, folder, check.value);
        }
      }
    }
    location.reload();
  }

  function marcarLeido() {
    for (let check of checks) {
      if (check.checked){
        Leido(false, folder, check.value);
      }
    }
    location.reload();
  }

  function marcarImportante() {
    for (let check of checks) {
      if (check.checked){
        Importante(false, folder, check.value);
      }
    }
    location.reload();
  }
</script>
@stop