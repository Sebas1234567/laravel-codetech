@extends('layout.admin')

@section('title')Creacion de Productos | CodeTechEvolution @stop

@section('styles')
<link href="{{ asset('admin/videos/styles.css') }}" rel="stylesheet">
<style>
  .tox .tox-promotion-link{
    display: none!important;
  }
  .tox .tox-statusbar a{
    display: none!important;
  }
</style>
@stop

@section('metas')<meta name="csrf-token" content="{{ csrf_token() }}"> @stop

@section('bred1')Tienda @stop
@section('bred2')Productos @stop

@section('contenido')
<div class="card border-top-secondary border-top-3 mb-4">
  <div class="card-header d-flex align-items-center">
    <i class="fa-duotone fa-browsers" style="font-size: 1.2rem;"></i>
    <strong class="ms-2">Nuevo Producto</strong>
  </div>
  <div class="card-body">
    <div class="tab-content rounded-bottom">
      @if ($errors->all())
        <div class="alert alert-danger" role="alert">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
        {{ html()->form('POST', '/admin/tienda/productos/')->attributes(['autocomplete' => 'off', 'files'=>'true', 'class'=>'row g-3'])->open() }}
          <div class="col-md-6">
            <label for="titulo" class="form-label">Titulo:</label>
            <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Ingrese el título del producto">
          </div>
          <div class="col-md-6">
            <label for="sku" class="form-label">Sku:</label>
            <input type="text" class="form-control" name="sku" id="sku" placeholder="Ingrese el sku del producto">
          </div>
          <div class="col-md-6">
            <label for="precio" class="form-label">Precio:</label>
            <input type="number" class="form-control" name="precio" id="precio" min="0.00" step="0.01" placeholder="Ingrese el precio del producto">
          </div>
          <div class="col-md-6">
            <label for="categoria" class="form-label">Categoria:</label>
            <select class="form-multi-select" name="categoria[]" id="categoria" multiple data-coreui-search="true" data-coreui-selection-type="tags">
              @foreach($categorias as $id => $nombre)
              <option value="{{ $id }}">{{ $nombre }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-12">
            <label for="descripcion" class="form-label">Descripcion:</label>
            <textarea class="form-control editorTiny" name="descripcion" id="descripcion" placeholder="Ingrese la descripción del producto"></textarea>
          </div>
          <div class="col-12">
            <label for="contenido" class="form-label">Contenido:</label>
            <textarea class="form-control editorTiny" name="contenido" id="contenido" placeholder="Ingrese el contenido del producto"></textarea>
          </div>
          <div class="col-12">
            <div class="mb-3">
              <label for="archivo">Archivo:</label>
              <span>Nombre archivos: <b>nombre_producto_n°img.ext</b></span>
              <input type="text" name="galeria" class="form-control" id="galeria" hidden="hidden">
              <div class="wrapper-upload">
                <div class="form">
                  <input type="file" name="archivo" class="file-input" id="archivo" accept="image/*" hidden>
                  <i class="fa-duotone fa-cloud-upload"></i>
                  <p>Examinar archivo para cargar</p>
                </div>
                <section class="upload progress-area"></section>
                <section class="upload uploaded-area"></section>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <label for="imagen" class="form-label">Imagen:</label>
            <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*">
          </div>
          <div class="col-md-6">
            <label for="archivo" class="form-label">Archivo:</label>
            <input type="file" class="form-control" name="archivo" id="archivo">
          </div>
          <div class="col-md-6">
            <label for="fecha_publicacion" class="form-label">Fecha de Publicación:</label>
            <div id="datePicker" data-coreui-footer="true" data-coreui-date="{{ \Carbon\Carbon::now()->format('m/d/Y') }}"></div>
          </div>
          <div class="col-md-6">
            <label for="demo" class="form-label">Demo:</label>
            <input type="url" class="form-control" name="demo" id="demo" placeholder="Ingrese la url del demo del producto">
          </div>
          <div class="col-12">
            <a href="{{ route('admin.tienda.productos.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
          {{ html()->form()->close() }}
      </div>
    </div>
  </div>
</div>
@stop

@section('scripts')
<script src="{{ asset('admin/vendors/jquery/js/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-head.tinymce-config/>
<script>
  var fecha = new Date();
  fecha.setDate(fecha.getDate() - 1);

  var options = {
    locale: 'es-PE',
    format: 'dd/MM/yyyy',
    minDate: fecha
  }
  var datePicker = new coreui.DatePicker(document.getElementById('datePicker'), options);

  setTimeout(() => {
    var input = document.querySelector('.picker-input-group input');
    input.name = 'fecha_publicacion';
    input.id = 'fecha_publicacion';
  }, 5000);

  const select3 = document.getElementById('categoria');
  const select3c = new coreui.MultiSelect(select3, {
    multiple: true,
    selectionType: 'tags',
    search: true
  });
  select3c._element.name='categoria[]';
</script>
<script>
  const form = document.querySelector(".form"),
  fileInput = document.querySelector(".file-input"),
  progressArea = document.querySelector(".progress-area"),
  uploadedArea = document.querySelector(".uploaded-area"),
  form_upload = document.querySelector("form#crear-form"),
  nombres = document.querySelector("#galeria");

  var Swalmodal = Swal.mixin({
      customClass: {
          confirmButton: "btn btn-success ms-3 text-white fw-semibold",
          cancelButton: "btn btn-danger text-white fw-semibold"
      },
      buttonsStyling: false
  });

  form.addEventListener("click", () => {
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
      } 
    }
    xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 300) {
          var jsonResponse = JSON.parse(xhr.responseText);
          if (nombres.value == ''){
              nombres.value = nombres.value + jsonResponse.archivo;
          }
          else{
              nombres.value = nombres.value + ';' + jsonResponse.archivo;
          }
          console.log(nombres.value)
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
@stop