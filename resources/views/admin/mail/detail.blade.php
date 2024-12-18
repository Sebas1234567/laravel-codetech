@extends('layout.mail')

@section('title'){{ $correo['asunto'] }} - Mail | CodeTechEvolution @stop

@section('metas')
<meta name="csrf-token" content="{{ csrf_token() }}"> 
<meta name="folder" content="{{ $folder }}">
@stop

@section('styles')
<style>
  .tox.tox-tinymce{
    height: 300px !important;
  }
</style>
@endsection

@section('contenido')
<div class="card email-app">
  <div class="card-body">
    <div class="btn-toolbar mb-4">
      <div class="btn-group me-1">
        <button class="btn btn-light" type="button" onclick="Leido(true, '{{ $folder }}', {{ $correo['uid'] }})">
          <i class="fa-duotone fa-envelope"></i>
        </button>
        <button class="btn btn-light" type="button" onclick="Favorito(true, '{{ $folder }}', {{ $correo['uid'] }})">
          <i class="@if ($correo['favorito'])fa-solid @else fa-regular @endif fa-star" @if ($correo['favorito'])style="color: #FFD43B;"@endif></i>
        </button>
        <button class="btn btn-light" type="button" onclick="Importante(true, '{{ $folder }}', {{ $correo['uid'] }})">
          <i class="fa-duotone fa-bookmark"></i>
        </button>
      </div>
      <div class="btn-group me-1">
        <button class="btn btn-light @if ($folder == 'Borradores') disabled @endif" type="button" @if ($folder != 'Borradores') onclick="showModal('Responder')" @endif>
          <i class="fa-duotone fa-reply"></i>
        </button>
        <button class="btn btn-light @if ($folder == 'Borradores') disabled @endif" type="button" @if ($folder != 'Borradores') onclick="showModal('Reenviar')"@endif >
          <i class="fa-duotone fa-share"></i>
        </button>
      </div>
      <button class="btn btn-light me-1" type="button" @if ($folder == 'Papelera') onclick="Eiminar(true, '{{ $folder }}', {{ $correo['uid'] }})" @else onclick="Papelera(true, '{{ $folder }}', {{ $correo['uid'] }})"  @endif>
        <i class="fa-duotone fa-trash-can"></i>
      </button>
      <div class="btn-group ms-auto">
        <button class="btn btn-light" type="button">
          <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button class="btn btn-light" type="button">
          <i class="fa-solid fa-chevron-right"></i>
        </button>
      </div>
    </div>
    <div class="message">
      <div class="message-details flex-wrap pb-3">
        <div class="message-headers d-flex flex-wrap">
          <div class="message-headers-subject w-100 fs-5 fw-semibold">{{ $correo['asunto'] }}</div>
          <div class="message-headers-from">{{ $correo['remiteN'] }}<span class="text-medium-emphasis">  ({{ $correo['remiteM'] }})</span></div>
          <div class="message-headers-date ms-auto">
            @if ($correo['adjuntos'])
              <i class="icon fa-solid fa-paperclip"></i>
            @endif {{ $correo['dia'] }}
          </div>
          @if ($folder == 'Enviados')
          <div class="message-headers-from w-100">Para: <span class="text-medium-emphasis">{{ $correo['to'] }}, {{ $correo['cc'] }}@if ($correo['bcc'] != ''), @endif {{ $correo['bcc'] }}</span></div>
          @endif
        </div>
        <hr>
        <div class="message-body">
          @if (str_contains($correo['cuerpo'], '<html>') || str_contains($correo['cuerpo'], '<div'))
          <iframe frameborder="0" srcdoc="{{ $correo['cuerpo'] }}" style="width: 100%; height: auto;"></iframe>
          @else
          {!! $correo['cuerpo'] !!}
          @endif
        </div>
        <hr>
        @foreach ($correo['files'] as $file)
          <div class="message-attachment">
            <span class="badge bg-danger-gradient me-2" style="font-size: 20px; background: none; color: {{ $file['color'] }}">
              <i class="{{ $file['icon'] }}"></i>
            </span>
            <b>{{ $file['name'] }}</b>
            <i> ({{ $file['size'] }})</i>
            <a href="{{ $file['url'] }}" target="_blank" rel="noopener noreferrer">
              <i class="fa-duotone fa-download"></i>
            </a>
          </div>
        @endforeach
        <hr>
        <div class="message-form" id="formResponse">
          <div class="modal position-static" tabindex="-1" id="modalMessage">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="titleModal"></h5>
                  <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close" onclick="closeModal();"></button>
                </div>
                <form action="" method="post" id="formDetails">
                  <div class="modal-body">
                    @csrf
                    <input type="hidden" name="uid" id="uid" value="{{ $correo['uid'] }}">
                    <input type="hidden" name="asunto" id="asunto">
                    <div class="col-12 d-none mb-3" id="msgReply">
                      <textarea class="form-control editorTiny" name="mensajeReply" id="mensajeReply" rows="5" placeholder="Mensaje"></textarea>
                    </div>
                    <div class="col-12 d-none mb-3" id="msgFord">
                      <textarea class="form-control editorTiny" name="mensajeFord" id="mensajeFord" rows="5" placeholder="Mensaje">{{ $correo['cuerpo'] }}</textarea>
                    </div>
                    <div class="mb-3">
                      <button class="btn btn-info" onclick="showAttach()" type="button">Adjuntos</button>
                    </div>
                    <div class="d-none mb-3" id="attach">
                      <label for="archivo">Adjuntos:</label>
                      <input type="text" name="adjuntos" class="form-control" id="adjuntos" hidden="hidden">
                      <input type="text" name="mime" class="form-control" id="mime" hidden="hidden">
                      <div class="wrapper-upload">
                          <div class="form">
                            <input type="file" name="archivo" class="file-input" id="archivo" accept="*" hidden>
                            <i class="fa-solid fa-cloud-upload"></i>
                            <p>Examinar archivo para cargar</p>
                          </div>
                          <section class="upload progress-area"></section>
                          <section class="upload uploaded-area"></section>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop

@section('scripts')
<x-head.tinymce-config/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  var modal = document.querySelector('#formResponse .modal');
  var title = document.getElementById('titleModal');
  var form = document.querySelector('.modal-body');
  var msgReply = document.getElementById('msgReply');
  var msgFord = document.getElementById('msgFord');
  var subject = document.getElementById('asunto');
  var mensaje =  `{{ $correo['cuerpo'] }}`;
  var asunto = "{{ $correo['asunto'] }}";
  var email = "{{ $correo['reply'] }}";
  var formMe = document.getElementById('formDetails');
  var folder = $('meta[name="folder"]').attr('content');

  function showModal(action) {
    if (action == 'Responder') {
      title.textContent = 'Re: ' + asunto;
      subject.value = 'Re: ' + asunto;
      var inputMail = '<input type="hidden" name="mail" id="mail" value="' + email + '" />';
      form.insertAdjacentHTML('beforeend', inputMail);
      msgReply.classList.remove('d-none');
      msgFord.classList.add('d-none');
      formMe.setAttribute('action','/mail/reply/'+folder);
      modal.classList.add('d-block');
    } else {
      title.textContent = 'Fwd: ' + asunto;
      subject.value = 'Fwd: ' + asunto;
      var nuevoDiv = document.createElement('div');
      nuevoDiv.className = 'col-12 mb-3';
      nuevoDiv.id = 'mailCont';
      var nuevoInput = document.createElement('input');
      nuevoInput.type = 'email';
      nuevoInput.className = 'form-control';
      nuevoInput.name = 'mail';
      nuevoInput.id = 'mail';
      nuevoInput.placeholder = 'Email';
      nuevoDiv.appendChild(nuevoInput);
      var primerElemento = form.firstChild;
      form.insertBefore(nuevoDiv, primerElemento);
      msgReply.classList.add('d-none');
      msgFord.classList.remove('d-none');
      formMe.setAttribute('action', '/mail/fordward/'+folder);
      modal.classList.add('d-block');
    }
  }

  function closeModal() {
    var elementoAEliminar = document.getElementById('mailCont');
    if (elementoAEliminar !== null) {
      elementoAEliminar.parentNode.removeChild(elementoAEliminar);
    } else {
      elementoAEliminar = document.getElementById('mail');
      elementoAEliminar.parentNode.removeChild(elementoAEliminar);
    }
    msgReply.classList.add('d-none');
    msgFord.classList.add('d-none');
    modal.classList.remove('d-block');
  }
</script>
<script>
  var csrfToken = $('meta[name="csrf-token"]').attr('content');
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
          if (folder == 'INBOX') {
            window.location.href = '/admin/mail';
          } else if (folder == 'Enviados') {
            window.location.href = '/admin/mail/sends';
          } else if (folder == 'Borradores') {
            window.location.href = '/admin/mail/drafts';
          } else if (folder == 'Spam') {
            window.location.href = '/admin/mail/junks';
          } else if (folder == 'Papelera') {
            window.location.href = '/admin/mail/trash';
          }
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
          if (folder == 'INBOX') {
            window.location.href = '/admin/mail';
          } else if (folder == 'Enviados') {
            window.location.href = '/admin/mail/sends';
          } else if (folder == 'Borradores') {
            window.location.href = '/admin/mail/drafts';
          } else if (folder == 'Spam') {
            window.location.href = '/admin/mail/junks';
          } else if (folder == 'Papelera') {
            window.location.href = '/admin/mail/trash';
          }
        }
      },
      error: function(error) {
        console.error('Error al enviar correo a la papelera :(', error);
      }
    });
  }

  function Eiminar(reload, folder, id) {
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
          if (folder == 'INBOX') {
            window.location.href = '/admin/mail';
          } else if (folder == 'Enviados') {
            window.location.href = '/admin/mail/sends';
          } else if (folder == 'Borradores') {
            window.location.href = '/admin/mail/drafts';
          } else if (folder == 'Spam') {
            window.location.href = '/admin/mail/junks';
          } else if (folder == 'Papelera') {
            window.location.href = '/admin/mail/trash';
          }
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
</script>
<script>
  const formA = document.querySelector(".form"),
  fileInput = document.querySelector(".file-input"),
  progressArea = document.querySelector(".progress-area"),
  uploadedArea = document.querySelector(".uploaded-area"),
  form_upload = document.querySelector("form#crear-form"),
  nombres = document.querySelector("#adjuntos"),
  mime = document.querySelector('#mime');
  var MimeType = '';

  var Swalmodal = Swal.mixin({
      customClass: {
          confirmButton: "btn btn-success ms-3 text-white fw-semibold",
          cancelButton: "btn btn-danger text-white fw-semibold"
      },
      buttonsStyling: false
  });

  var iconos = {
      'pdf': 'fa-light fa-file-pdf',
      'doc': 'fa-light fa-file-word',
      'docx': 'fa-light fa-file-word',
      'xls': 'fa-light fa-file-excel',
      'ppt': 'fa-regular fa-file-powerpoint',
      'pptx': 'fa-regular fa-file-powerpoint',
      'xlsx': 'fa-light fa-file-excel',
      'xlsm': 'fa-light fa-file-excel',
      'csv': 'fa-light fa-file-excel',
      'zip': 'fa-light fa-file-zipper',
      'rar': 'fa-light fa-file-zipper',
      'txt': 'fa-light fa-file-lines',
      'default': 'fa-light fa-file',
      'css': 'fa-regular fa-file-code',
      'html':'fa-regular fa-file-code',
      'php': 'fa-regular fa-file-code',
      'js':'fa-regular fa-file-code',
      'cs':'fa-regular fa-file-code',
      'py':'fa-regular fa-file-code',
      'sql':'fa-regular fa-file-code',
  };

  formA.addEventListener("click", () => {
    fileInput.click();
  });

  fileInput.onchange = ({ target }) => {
    let file = target.files[0];
    if (file) {
      let fileName = file.name;
      if (fileName.length >= 12) {
          let splitName = fileName.split('.');
          fileName = splitName[0].substring(0, 6) + "..."+ splitName[0].substring(splitName[0].length-7)+ "." + splitName[1];
      }
      let typeFile = file.type.split('/')[0];
      MimeType = file.type;
      uploadFile(file, fileName, typeFile, file.name);
    }
  }

  function uploadFile(file, name, type, name2) {
    var data = new FormData();
    data.append("archivo",file);
    let fileSize = 0;
    let xhr = new XMLHttpRequest();

    xhr.upload.onprogress = (e) => {
      let fileLoaded = Math.floor((e.loaded / e.total) * 100);
      let fileTotal = Math.floor(e.total / 1000);
      (fileTotal < 1024) ? fileSize = fileTotal + " KB" : fileSize = (e.loaded / (1024 * 1024)).toFixed(2) + " MB";
      if (type == 'image') {
        let progressHTML = `<li class="row-upl">
                    <i class="fa-light fa-file-image"></i>
                    <div class="content">
                        <div class="details">
                            <span class="name">${name} • Uploading</span>
                            <span class="percent">${fileLoaded}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress" style="width: ${fileLoaded}%"></div>
                        </div>
                    </div>
                </li>`;
        uploadedArea.classList.add("onprogress");
        progressArea.innerHTML = progressHTML;
        if (e.loaded == e.total) {
            progressArea.innerHTML = "";
            let uploadedHTML = `<li class="row-upl">
                    <div class= "content">
                        <i class="fa-light fa-file-image"></i>
                        <div class="details">
                            <span class="name">${name} • Uploaded</span>
                            <span class="size">${fileSize}</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-check"></i>
                </li>`;
            uploadedArea.classList.remove("onprogress");
            uploadedArea.insertAdjacentHTML("afterbegin", uploadedHTML);
        }
      } else if (type == 'video') {
        let progressHTML = `<li class="row-upl">
                    <i class="fa-light fa-file-video"></i>
                    <div class="content">
                        <div class="details">
                            <span class=name">${name} • Uploading</span>
                            <span class="percent">${fileLoaded}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress" style="width: ${fileLoaded}%"></div>
                        </div>
                    </div>
                </li>`;
        uploadedArea.classList.add("onprogress");
        progressArea.innerHTML = progressHTML;
        if (e.loaded == e.total) {
            progressArea.innerHTML = "";
            let uploadedHTML = `<li class="row-upl">
                    <div class= "content">
                        <i class="fa-light fa-file-video"></i>
                        <div class="details">
                            <span class="name">${name} • Uploaded</span>
                            <span class="size">${fileSize}</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-check"></i>
                </li>`;
            uploadedArea.classList.remove("onprogress");
            uploadedArea.insertAdjacentHTML("afterbegin", uploadedHTML);
        }
      } else if (type == 'audio') {
        let progressHTML = `<li class="row-upl">
                    <i class="fa-light fa-file-music"></i>
                    <div class="content">
                        <div class="details">
                            <span class=name">${name} • Uploading</span>
                            <span class="percent">${fileLoaded}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress" style="width: ${fileLoaded}%"></div>
                        </div>
                    </div>
                </li>`;
        uploadedArea.classList.add("onprogress");
        progressArea.innerHTML = progressHTML;
        if (e.loaded == e.total) {
            progressArea.innerHTML = "";
            let uploadedHTML = `<li class="row-upl">
                    <div class= "content">
                        <i class="fa-light fa-file-music"></i>
                        <div class="details">
                            <span class="name">${name} • Uploaded</span>
                            <span class="size">${fileSize}</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-check"></i>
                </li>`;
            uploadedArea.classList.remove("onprogress");
            uploadedArea.insertAdjacentHTML("afterbegin", uploadedHTML);
        }
      } else {
        var extension = name2.split('.').pop().toLowerCase();
        if (iconos.hasOwnProperty(extension)) {
            var icono = iconos[extension];
        } else {
            var icono = iconos['default'];
        }
        let progressHTML = `<li class="row-upl">
                    <i class="${icono}"></i>
                    <div class="content">
                        <div class="details">
                            <span class=name">${name} • Uploading</span>
                            <span class="percent">${fileLoaded}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress" style="width: ${fileLoaded}%"></div>
                        </div>
                    </div>
                </li>`;
        uploadedArea.classList.add("onprogress");
        progressArea.innerHTML = progressHTML;
        if (e.loaded == e.total) {
            progressArea.innerHTML = "";
            let uploadedHTML = `<li class="row-upl">
                    <div class= "content">
                        <i class="${icono}"></i>
                        <div class="details">
                            <span class="name">${name} • Uploaded</span>
                            <span class="size">${fileSize}</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-check"></i>
                </li>`;
            uploadedArea.classList.remove("onprogress");
            uploadedArea.insertAdjacentHTML("afterbegin", uploadedHTML);
        }
      }
    };
    xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 300) {
        var jsonResponse = JSON.parse(xhr.responseText);
        if (nombres.value == ''){
          nombres.value = nombres.value + jsonResponse.archivo;
        } else {
          nombres.value = nombres.value + ';' + jsonResponse.archivo;
        }
        if (mime.value == '') {
          mime.value = mime.value + MimeType;
        } else {
          mime.value = mime.value + ';' + MimeType;
        }
        console.log(nombres.value);
        console.log(mime.value);
        Swalmodal.fire(
          'Cargado!',
          'El archivo se ha cargado satisfactoriamente.',
          'success'
        )
        fileInput.value=''
      } else {
        console.error('Error en la solicitud. Estado:', xhr.status, 'Texto:', xhr.statusText);
        Swalmodal.fire(
          'Error',
          'Hubo un error al cargar el archivo. Revise la consola para más detalles.',
          'error'
        );
      }
    };
    xhr.open("POST", "/cargar/file",true);
    xhr.setRequestHeader('X-CSRF-TOKEN', token);
    xhr.send(data);
  }
</script>
<script>
  function showAttach() {
    var attach = document.getElementById('attach');
    attach.classList.remove('d-none')
  }
</script>
@stop