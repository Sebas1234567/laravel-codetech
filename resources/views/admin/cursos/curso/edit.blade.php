@extends('layout.admin')

@section('title')Edición de Cursos | CodeTechEvolution @stop

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

@section('bred1')Cursos @stop
@section('bred2')Cursos @stop

@section('contenido')
<div class="card border-top-secondary border-top-3 mb-4">
  <div class="card-header d-flex align-items-center">
    <i class="fa-duotone fa-graduation-cap" style="font-size: 1.2rem;"></i>
    <strong class="ms-2">Editar Curso</strong>
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
        {{ html()->modelForm($curso, 'PATCH')->route('admin.cursos.curso.update',$curso->id)->attributes(['autocomplete' => 'off','files'=>'true','class'=>'row g-3'])->open() }}
          <div class="col-md-6">
            <label for="titulo" class="form-label">Titulo:</label>
            <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Ingrese el título del producto" value="{{ $curso->titulo }}">
          </div>
          <div class="col-md-6">
            <label for="slug" class="form-label">Slug:</label>
            <input type="text" class="form-control" name="slug" id="slug" placeholder="Ingrese el slug del curso" value="{{ $curso->slug }}">
          </div>
          <div class="col-md-6">
            <label for="precio" class="form-label">Precio:</label>
            <input type="number" class="form-control" name="precio" id="precio" min="0.00" step="0.01" placeholder="Ingrese el precio del curso" value="{{ $curso->precio }}">
          </div>
          <div class="col-md-6">
            <label for="categoria" class="form-label">Categoria:</label>
            <select class="form-select" name="idcategoria" id="idcategoria" aria-label="Selector de categorias">
              <option selected>Seleccione una categoria</option>
              @foreach($categorias as $id => $nombre)
              <option value="{{ $id }}" @if ($id == $curso->idcategoria)selected @endif>{{ $nombre }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-12">
            <label for="descripcion" class="form-label">Descripcion:</label>
            <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Ingrese la descripción del curso" rows="5">{{ $curso->descripcion }}</textarea>
          </div>
          <div class="col-12">
            <label for="contenido" class="form-label">Contenido:</label>
            <textarea class="form-control editorTiny" name="contenido" id="contenido" placeholder="Ingrese el contenido del curso">{{ $curso->contenido }}</textarea>
          </div>
          <div class="col-md-6">
            <label for="imagen" class="form-label">Imagen:</label>
            <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*">
          </div>
          <div class="col-md-6">
            <label for="fecha_publicacion" class="form-label">Fecha de Publicación:</label>
            <div id="datePicker" data-coreui-footer="true" data-coreui-date="{{ \Carbon\Carbon::parse($curso->fecha_publicacion)->format('m/d/Y') }}"></div>
          </div>
          <div class="col-md-6">
            <label for="certificado" class="form-label">Certificado:</label>
            <div class="form-check form-switch form-switch-lg">
              <input class="form-check-input" type="checkbox" role="switch" name="certificado" id="certificado" value="{{ $curso->certificado }}" @if ($curso->certificado)checked @endif>
              <label class="form-check-label" for="certificado" id="lbl_cert">@if ($curso->certificado)Certificado Habilitado @else Certificado Inhabilitado @endif</label>
            </div>
          </div>
          <div class="col-12">
            <a href="{{ route('admin.cursos.curso.index') }}" class="btn btn-secondary">Cancelar</a>
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
  $("#certificado").on( 'change', function() {
    if( $(this).is(':checked') ) {
      $('#lbl_cert').text('Certificado Habilitado');
      $(this).val('1');
    } else {
      $('#lbl_cert').text('Certificado Inhabilitado');
      $(this).val('0');
    }
  });
</script>
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
</script>
@stop