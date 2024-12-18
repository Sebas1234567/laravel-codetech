@extends('layout.admin')

@section('title')Edición de Entradas | CodeTechEvolution @stop

@section('styles')
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

@section('bred1')Blog @stop
@section('bred2')Entradas @stop

@section('contenido')
<div class="card border-top-secondary border-top-3 mb-4">
  <div class="card-header d-flex align-items-center">
    <i class="fa-duotone fa-browsers" style="font-size: 1.2rem;"></i>
    <strong class="ms-2">Editar Entrada</strong>
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
        {{ html()->modelForm($entrada, 'PATCH')->route('admin.blog.entradas.update',$entrada->id)->attributes(['autocomplete' => 'off','files'=>'true','class'=>'row g-3'])->open() }}
          <div class="col-md-6">
            <label for="titulo" class="form-label">Titulo:</label>
            <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Ingrese el título del post" value="{{ $entrada->titulo }}">
          </div>
          <div class="col-md-6">
            <label for="slug" class="form-label">Slug:</label>
            <input type="text" class="form-control" name="slug" id="slug" placeholder="Ingrese el slug del post" value="{{ $entrada->slug }}">
          </div>
          <div class="col-md-4">
            <label for="idvideo" class="form-label">Video:</label>
            <select class="form-select" aria-label="Selector de videos" name="idvideo" id="idvideo">
              <option selected>Seleccione un video</option>
              @foreach($videos as $id => $nombre)
              <option value="{{ $id }}" @if ($id == $entrada->idvideo)selected @endif>{{ $nombre }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label for="idautor" class="form-label">Autor:</label>
            <select class="form-select" aria-label="Selector de videos" name="idautor" id="idautor">
              <option selected>Seleccione un autor</option>
              @foreach($autores as $id => $nombre)
              <option value="{{ $id }}" @if ($id == $entrada->idautor)selected @endif>{{ $nombre }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label for="imagen" class="form-label">Categoria:</label>
            <select class="form-multi-select" name="idcategoria[]" id="idcategoria" multiple data-coreui-search="true" data-coreui-selection-type="tags">
              @php
                $categorias2 = explode(',', $entrada->categorias);
              @endphp
              @foreach($categorias as $id => $nombre)
                <option value="{{ $id }}" @if (in_array($id, $categorias2))selected @endif>{{ $nombre }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-12">
            <label for="descripcion" class="form-label">Descripcion:</label>
            <textarea class="form-control" name="descripcion" id="descripcion" rows="5" placeholder="Ingrese un breve descripción para el post">{{ $entrada->descripcion }}</textarea>
          </div>
          <div class="col-12">
            <label for="contenido" class="form-label">Contenido:</label>
            <textarea class="form-control editorTiny" name="contenido" id="contenido" placeholder="Ingrese el contenido del post">{{ $entrada->contenido }}</textarea>
          </div>
          <div class="col-md-6">
            <label for="contenido" class="form-label">Fecha de Publicación:</label>
            <div id="datePicker" data-coreui-footer="true" data-coreui-date="{{ \Carbon\Carbon::parse($entrada->fecha_publicacion)->format('m/d/Y') }}"></div>
          </div>
          <div class="col-md-6">
            <label for="imagen" class="form-label">Imagen:</label>
            <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*">
          </div>
          <div class="col-12">
            <a href="{{ route('admin.blog.entradas.index') }}" class="btn btn-secondary">Cancelar</a>
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

  const select3 = document.getElementById('idcategoria');
  const select3c = new coreui.MultiSelect(select3, {
    multiple: true,
    selectionType: 'tags',
    search: true
  });
  select3c._element.name='idcategoria[]';
</script>
@stop