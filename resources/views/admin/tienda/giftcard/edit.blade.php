<div class="modal-header">
  <h5 class="modal-title" id="editarGiftcardLabel">Editar Giftcard</h5>
  <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
</div>
{{ html()->modelForm($giftcard, 'PATCH')->route('admin.tienda.giftcard.update',$giftcard->id)->attribute('autocomplete', 'off')->open() }}
<div class="modal-body">
  <div class="mb-3">
    <label class="form-label" for="codigo">Código:</label>
    <div class="input-group">
      <input type="text" name="codigo" id="codigo" class="form-control" placeholder="Ingrese el codigo de la giftcard" aria-label="Codigo giftcard" aria-describedby="button-addon2" value="{{ $giftcard->codigo }}">
      <button class="btn btn-outline-dark" type="button" id="button-addon2" onclick="generarTexto('codigo')">Generar</button>
    </div>
  </div>
  <div class="mb-3">
    <label class="form-label" for="valor">Valor:</label>
    <input type="number" class="form-control" name="valor" id="valor" min="0.00" step="0.01" value="{{ $giftcard->valor }}">
  </div>
  <div class="mb-3">
    <label class="form-label" for="nota">Nota:</label>
    <textarea class="form-control" id="nota" name="nota" rows="10" placeholder="Ingrese una pequeña nota para la giftcard">{{ $giftcard->nota }}</textarea>
  </div>
</div>
<div class="modal-footer">
  <button type="reset" class="btn btn-secondary" data-coreui-dismiss="modal">Cancelar</button>
  <button type="submit" class="btn btn-primary">Guardar</button>
</div>
{{ html()->form()->close() }}