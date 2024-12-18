@extends('layout.admin')

@section('title')Edición de Promocion | CodeTechEvolution @stop

@section('styles')
@stop

@section('metas')<meta name="csrf-token" content="{{ csrf_token() }}"> @stop

@section('bred1')Admin @stop
@section('bred2')Promociones @stop

@section('contenido')
<div class="card border-top-secondary border-top-3 mb-4">
  <div class="card-header d-flex align-items-center">
    <i class="fa-duotone fa-badge-percent" style="font-size: 1.2rem;"></i>
    <strong class="ms-2">Editar Promocion</strong>
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
        {{ html()->modelForm($promocion, 'PATCH')->route('admin.promocion.promociones.update',$promocion->id)->attributes(['autocomplete' => 'off','files'=>'true','class'=>'row g-3','enctype'=>'multipart/form-data'])->open() }}
        <div class="mb-3">
          <label class="form-label" for="titulo">Titulo:</label>
          <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Ingrese el titulo de la promoción" value="{{ $promocion->titulo }}">
        </div>
        <div class="mb-3">
          <label class="form-label" for="descripcion">Descripcion:</label>
          <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Ingrese la descripcion de la promoción" rows="6" maxlength="255">{{ $promocion->descripcion }}</textarea>
        </div>
        <div class="mb-3">
          <label class="form-label" for="fechas">Fecha de Inicio y Fin:</label>
          <div id="fechaInicioFin" data-coreui-start-date="{{ \Carbon\Carbon::parse($promocion->fecha_inicio)->format('m/d/Y') }}"
            data-coreui-end-date="{{ \Carbon\Carbon::parse($promocion->fecha_fin)->format('m/d/Y') }}"></div>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="porcentaje">Porcentaje:</label>
          <input type="number" name="porcentaje" id="porcentaje" class="form-control" placeholder="Ingrese el porcentaje de descuento de la promoción" value="{{ $promocion->porcentaje }}">
        </div>
        <div class="col-md-6">
          <label class="form-label" for="imagen">Imagen:</label>
          <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
        </div>
        <div class="col-12">
          <a href="{{ route('admin.promocion.promociones.index') }}" class="btn btn-secondary">Cancelar</a>
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
<script>
  const fechaInicioFin = document.getElementById('fechaInicioFin')
  if (fechaInicioFin) {
    var fecha = new Date();
    fecha.setDate(fecha.getDate() - 1);

    const optionsfechaInicioFin = {
      locale: 'es-PE',
      format: 'dd/MM/yyyy',
      minDate: fecha,
    }

    new coreui.DateRangePicker(document.getElementById('fechaInicioFin'), optionsfechaInicioFin)
  }

  setTimeout(() => {
    var inputstart = document.querySelector('[name=date-range-picker-start-date-fechaInicioFin]');
    var inputend = document.querySelector('[name=date-range-picker-end-date-fechaInicioFin]');
    inputstart.name = 'fechaInicio';
    inputstart.id = 'fechaInicio';
    inputend.name = 'fechaFin';
    inputend.id = 'fechaFin';
  }, 5000);
</script>
@stop