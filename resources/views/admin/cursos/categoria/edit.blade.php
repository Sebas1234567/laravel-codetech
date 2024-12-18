<div class="modal-header">
  <h5 class="modal-title" id="editarCategoriaLabel">Editar Categoría</h5>
  <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
</div>
{{ html()->modelForm($categoria, 'PATCH')->route('admin.cursos.categoria.update',$categoria->id)->attribute('autocomplete', 'off')->open() }}
<div class="modal-body">
  <div class="mb-3">
    <label class="form-label" for="nombre">Nombre:</label>
    <input class="form-control" name="nombre" id="nombre" type="text" placeholder="Ingrese el nombre de la categoría" value="{{ $categoria->nombre }}">
  </div>
  <div class="mb-3">
    <label class="form-label" for="descripcion">Descripción:</label>
    <textarea class="form-control" id="descripcion" name="descripcion" rows="10" placeholder="Ingrese una pequeña descripción para la categoría">{{ $categoria->descripcion }}</textarea>
  </div>
</div>
<div class="modal-footer">
  <button type="reset" class="btn btn-secondary" data-coreui-dismiss="modal">Cancelar</button>
  <button type="submit" class="btn btn-primary">Guardar</button>
</div>
{{ html()->form()->close() }}