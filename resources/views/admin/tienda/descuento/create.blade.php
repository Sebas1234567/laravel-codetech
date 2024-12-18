@extends('layout.admin')

@section('title')Creación de Descuentos | CodeTechEvolution @stop

@section('styles')
@stop

@section('metas')<meta name="csrf-token" content="{{ csrf_token() }}"> @stop

@section('bred1')Tienda @stop
@section('bred2')Descuentos @stop

@section('contenido')
<div class="card border-top-secondary border-top-3 mb-4">
  <div class="card-header d-flex align-items-center">
    <i class="fa-duotone fa-badge-dollar" style="font-size: 1.2rem;"></i>
    <strong class="ms-2">Nuevo Descuento</strong>
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
        {{ html()->form('POST', '/admin/tienda/descuento/')->attribute('autocomplete', 'off')->open() }}
        <div class="mb-3">
          <label class="form-label" for="codigo">Codigo:</label>
          <div class="input-group">
            <input type="text" name="codigo" id="codigo" class="form-control" placeholder="Ingrese el codigo del descuento" aria-label="Codigo descuento" aria-describedby="button-addon2" value="{{ old('codigo') }}">
            <button class="btn btn-outline-dark" type="button" id="button-addon2" onclick="generarTexto('codigo')">Generar</button>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="cantidad">Cantidad:</label>
          <div class="input-group mb-3">
            <div class="input-group-text">
              <label for="tipo_cant"><i class="fa-duotone fa-percent" id="symbol"></i></label>
              <input class="form-check-input mt-0" type="checkbox" name="tipo_cant" id="tipo_cant" value="0" aria-label="Checkbox for following text input" hidden {{ old('tipo_cant') == 1 ? 'checked' : '' }}>
            </div>
            <input type="number" class="form-control" name="cantidad" id="cantidad" min="0.00" step="0.01" aria-label="Text input with checkbox" value="{{ old('cantidad') }}">
          </div>
        </div>
        <div class="mb-3">
          <label for="tipo">Tipo de Descuento:</label>
          <select class="form-select" id="tipo" name="tipo" aria-label="Tipo descuento">
            <option selected="" value="0">Seleccione un tipo de descuento</option>
            <option value="producto" {{ old('tipo') == 'producto' ? 'selected' : '' }}>Producto</option>
            <option value="general" {{ old('tipo') == 'general' ? 'selected' : '' }}>General</option>
            <option value="extras" {{ old('tipo') == 'extras' ? 'selected' : '' }}>Extras</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label" for="fechas">Fecha de Inicio y Fin:</label>
          <div id="fechaInicioFin" data-coreui-start-date="@if (old('fechaInicio')){{ \Carbon\Carbon::createFromFormat('d/m/Y', old('fechaInicio'))->format('m/d/Y') }}@endif"
            data-coreui-end-date="@if (old('fechaFin')){{ \Carbon\Carbon::createFromFormat('d/m/Y', old('fechaFin'))->format('m/d/Y') }}@endif"></div>
        </div>
        <div class="mb-3" id="div-prod" hidden>
          <label for="tipo">Productos:</label>
          <select class="form-multi-select" name="productos[]" id="productos" multiple data-coreui-search="true" data-coreui-selection-type="tags">
            @foreach($productos as $id => $nombre)
            <option value="{{ $id }}">{{ $nombre }}</option>
            @endforeach
          </select>
        </div>
        <a href="{{ route('admin.tienda.descuento.index') }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Guardar</button>
        {{ html()->form()->close() }}
      </div>
    </div>
  </div>
</div>
@stop

@section('scripts')
<script src="{{ asset('admin/vendors/jquery/js/jquery.min.js') }}"></script>

<script>
  function generarTexto(input) {
    const caracteres = '0123456789ABCDEF';
    let resultado = '';
    const inputT = document.getElementById(input);

    for (let i = 0; i < 10; i++) {
      const indice = Math.floor(Math.random() * caracteres.length);
      resultado += caracteres.charAt(indice);
    }

    inputT.value = resultado;
  }
</script>

<script>
  var tipoCheck = document.getElementById("tipo_cant");
  var symbol = document.getElementById("symbol");
  tipoCheck.addEventListener("change", function () {
    if (tipoCheck.checked) {
      symbol.classList.remove("fa-percent");
      symbol.classList.add("fa-dollar-sign");
      console.log('marcado')
    } else {
      symbol.classList.remove("fa-dollar-sign");
      symbol.classList.add("fa-percent");
      console.log('desmarcado')
    }
  });
</script>
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

  const select3 = document.getElementById('productos');
  const select3c = new coreui.MultiSelect(select3, {
    multiple: true,
    selectionType: 'tags',
    search: true
  });
  select3c._element.name='productos[]';
</script>
<script>
  var tipo = document.getElementById('tipo');
  tipo.addEventListener("change", function(){
    if(this.value == "producto"){
      var select = document.getElementById('div-prod');
      select.removeAttribute("hidden");
    } else{
      var select = document.getElementById('div-prod');
      select.setAttribute("hidden","");
    }
  })
</script>

@stop