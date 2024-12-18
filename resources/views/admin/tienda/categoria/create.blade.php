<div class="modal-header">
  <h5 class="modal-title" id="crearCategoriaLabel">Nueva Categoría</h5>
  <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
</div>
{{ html()->form('POST', '/admin/tienda/categoria/')->attribute('autocomplete', 'off')->open() }}
<div class="modal-body">
  <div class="mb-3">
    <label class="form-label" for="nombre">Nombre:</label>
    <input class="form-control" name="nombre" id="nombre" type="text" placeholder="Ingrese el nombre de la categoría">
  </div>
  <div class="mb-3">
    <label for="padre_id">Categoría Padre:</label>
    <select class="form-select" id="padre_id" name="padre_id" aria-label="Categoria padre">
      <option selected="" value="0">Seleccione una categoria</option>
      @foreach ($categoriasPadre as $padre)
      <option value="{{ $padre->id }}">{{ $padre->nombre }}</option>
      @endforeach
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label" for="descripcion">Descripción:</label>
    <textarea class="form-control" id="descripcion" name="descripcion" rows="10" placeholder="Ingrese una pequeña descripción para la categoría"></textarea>
  </div>
</div>
<div class="modal-footer">
  <button type="reset" class="btn btn-secondary" data-coreui-dismiss="modal">Cancelar</button>
  <button type="submit" class="btn btn-primary">Guardar</button>
</div>
{{ html()->form()->close() }}