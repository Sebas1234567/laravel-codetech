@extends('layout.mail')

@section('title')Redactar Correo | CodeTechEvolution @stop

@section('metas')
<meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('contenido')
<div class="card email-app">
  <div class="card-body">
    <form action="/admin/mail/create" method="post" files="true" autocomplete="true">
      @csrf
      <div class="row mb-3">
        <label class="col-2 col-sm-1 col-form-label" for="to">Para:</label>
        <div class="col-10 col-sm-11">
          <input class="form-control" id="to" name="to" type="text" placeholder="Ingrese los emails separados por comas">
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-2 col-sm-1 col-form-label" for="cc">CC:</label>
        <div class="col-10 col-sm-11">
          <input class="form-control" id="cc" name="cc" type="text" placeholder="Ingrese los emails separados por comas">
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-2 col-sm-1 col-form-label" for="bcc">BCC:</label>
        <div class="col-10 col-sm-11">
          <input class="form-control" id="bcc" name="bcc" type="text" placeholder="Ingrese los emails separados por comas">
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-2 col-sm-1 col-form-label" for="subject">Asunto:</label>
        <div class="col-10 col-sm-11">
          <input class="form-control" id="subject" name="subject" type="text" placeholder="Asunto">
        </div>
      </div>
      <div class="row">
        <div class="col-sm-11 ms-auto">
          <div class="mb-3">
            <textarea class="form-control editorTiny" name="mensaje" id="mensaje" placeholder="Mensaje"></textarea>
          </div>
          <div class="mb-3">
            <button class="btn btn-info" onclick="showAttach()" type="button"><i class="fa-solid fa-paperclip" style="margin-right: 5px"></i> Adjuntos</button>
          </div>
          <div class="d-none mb-3" id="attach">
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
          <div class="mb-3">
            <button class="btn btn-success" type="submit"><i class="fa-duotone fa-paper-plane-top" style="margin-right: 5px"></i> Enviar</button>
            <a class="btn btn-danger" href="{{ route('admin.mail.index') }}"><i class="fa-duotone fa-message-xmark" style="margin-right: 5px"></i> Descartar</a>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@stop

@section('scripts')
<x-head.tinymce-config/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    attach.classList.toggle('d-none')
  }
</script>
@stop