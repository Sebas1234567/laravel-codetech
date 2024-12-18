<div class="modal-header">
  <h5 class="modal-title" id="crearAutorLabel">Nuevo Autor</h5>
  <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
</div>
{{ html()->form('POST', '/admin/blog/autor/')->attribute('autocomplete', 'off')->open() }}
<div class="modal-body">
  <div class="mb-3">
    <label class="form-label" for="nombre">Nombre:</label>
    <input class="form-control" name="nombre" id="nombre" type="text" placeholder="Ingrese el nombre del autor">
  </div>
  <div class="mb-3">
    <label class="form-label" for="descripcion">Descripción:</label>
    <textarea class="form-control" id="descripcion" name="descripcion" rows="12" placeholder="Ingrese una pequeña descripción para el autor"></textarea>
  </div>
</div>
<div class="modal-footer">
  <button type="reset" class="btn btn-secondary" data-coreui-dismiss="modal">Cancelar</button>
  <button type="submit" class="btn btn-primary">Guardar</button>
</div>
{{ html()->form()->close() }}