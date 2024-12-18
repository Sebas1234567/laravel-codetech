@extends('layout.admin')

@section('title')Listado de Giftcards | CodeTechEvolution @stop

@section('styles')
<link href="{{ asset('admin/vendors/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('admin/css/giftcard.css') }}" rel="stylesheet">
<style>
  .btn-group{
    display: flex;
  }
  .badge{
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute
  }
  .badge-usa{
    margin-left: 10px;
    margin-top: 10px;
  }
  .badge-est{
    margin-left: 90px;
    margin-top: 10px;
  }
</style>
@stop

@section('metas')<meta name="csrf-token" content="{{ csrf_token() }}"> @stop

@section('bred1')Tienda @stop
@section('bred2')Giftcards @stop

@section('contenido')
<div class="card border-top-secondary border-top-3 mb-4">
  <div class="card-header d-flex align-items-center">
    <i class="fa-duotone fa-gift-card" style="font-size: 1.2rem;"></i>
    <strong class="ms-2">Listado de Giftcards</strong>
    <button type="button" class="btn btn-secondary ms-2" id="crearGift" data-coreui-toggle="modal" data-coreui-target="#crearGiftcard">
      <i class="fa-regular fa-circle-plus"></i>
      Nuevo
    </button>
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
        <div class="row row-cols-1 row-cols-md-2 g-4">
          @foreach ($giftcards as $gift)
          <div class="col col-gift">
            <div class="cont-gift">
              <div class="giftcard">
                <div class="background-gift"></div>
                <p class="text-gift">Gift-Card</p>
                <img src="{{ asset('admin/assets/img/logo-ai.png') }}" class="logo" alt="CodeTech">
                <img src="{{ asset('admin/assets/img/logo-gc.png') }}" class="detail-logo" alt="Code">
                <img src="{{ asset('admin/assets/img/regalos.png') }}" class="gifts" alt="Regalos">
              </div>
              <div class="footer-giftcard">
                <p class="message">{{ $gift->nota }}</p>
                <h3 class="price">S/. {{ $gift->valor }}</h3>
              </div>
            </div>
            <div class="gift-buttons">
              <div class="btn-group-vertical" role="group" aria-label="Actions">
                <a href="" class="btn btn-info"><i class="fa-duotone fa-paper-plane-top"></i></a>
                <button class="btn btn-warning me-2 editarGift" type="button" data-id="{{ $gift->id }}" data-coreui-toggle="modal" data-coreui-target="#editarGiftcard">
                  <i class="fa-duotone fa-pen-to-square"></i>
                </button>
                <button type="button" class="btn btn-danger delete" data-id="{{ $gift->id }}"><i class="fa-solid fa-trash-can"></i></button>
              </div>
            </div>
            @if ($gift->usado)
              <span class="badge bg-success-gradient badge-usa">No usado</span>
            @else
              <span class="badge bg-danger-gradient badge-usa">Usado</span>
            @endif
            @if ($gift->estado)
              <span class="badge bg-success-gradient badge-est">Activo</span>
            @else
              <span class="badge bg-danger-gradient badge-est">Inactivo</span>
            @endif
          </div>
          @endforeach
        </div>
        <div class="row mt-5">
          <nav aria-label="pag-videos">
            <ul class="pagination justify-content-center">
              <li class="page-item @if ($giftcards->onFirstPage())disabled @endif">
                <a class="page-link" href="{{ $giftcards->previousPageUrl() }}">Anterior</a>
              </li>

              @for ($i=1; $i < $giftcards->lastPage()+1; $i++)
              <li class="page-item @if ($i == $giftcards->currentPage())active @endif" @if ($i == $giftcards->currentPage())aria-current="page"@endif>
                <a class="page-link" href="{{ $giftcards->url($i) }}">{{ $i }}</a>
              </li>
              @endfor

              <li class="page-item @if ($giftcards->lastPage() == $giftcards->currentPage())disabled @endif">
                <a class="page-link" href="{{ $giftcards->nextPageUrl() }}">Siguiente</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>
@stop

@section('modals')
<div class="modal fade" id="crearGiftcard" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="crearGiftcardLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content" id="createContent">
    </div>
  </div>
</div>
<div class="modal fade" id="editarGiftcard" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="editarGiftcardLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content" id="editContent">
    </div>
  </div>
</div>
@stop

@section('scripts')
<script src="{{ asset('admin/vendors/jquery/js/jquery.min.js') }}"></script>
<script src="{{ asset('admin/vendors/datatables.net/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('admin/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/js/datatables.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $(function() {
    var Swalmodal = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success ms-3 text-white fw-semibold",
        cancelButton: "btn btn-danger text-white fw-semibold"
      },
      buttonsStyling: false
    });

    $('.delete').click(function() {
      var registroId = $(this).data('id');
      var csrfToken = $('meta[name="csrf-token"]').attr('content');

      Swalmodal.fire({
        title: "Estás seguro?",
        text: "¡No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "¡Sí, eliminar!",
        cancelButtonText: "No, cancelar!",
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': csrfToken
            }
          });

          $.ajax({
            type: 'DELETE',
            url: '/admin/tienda/giftcard/' + registroId,
            success: function (data) {
              Swalmodal.fire(
                  'Eliminado!',
                  'El registro ha sido eliminado satisfactoriamente.',
                  'success'
              ).then(function () {
                  location.reload();
              });
            },
            error: function () {
              Swalmodal.fire(
                  'Error',
                  'Hubo un error al eliminar el registro.',
                  'error'
              );
            }
          });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          Swalmodal.fire({
            title: "Cancelado",
            text: "El registro no ha sido eliminado :)",
            icon: "error"
          });
        }
      });
    });
  });
</script>
<script>
  function generarTexto(input) {
    const caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    let resultado = '';
    const inputT = document.getElementById(input);
    for (let i = 0; i < 19; i++) {
      if (i % 5 === 4) {
        resultado += ' ';
      } else {
        const indice = Math.floor(Math.random() * caracteres.length);
        resultado += caracteres.charAt(indice);
      }
    }
    inputT.value = resultado;
  }
</script>
<script>
  $('#crearGift').click(function () {
    $.ajax({
      url: '/admin/tienda/giftcard/create',
      method: 'GET',
      dataType: 'html',
      success: function (data) {
        $('#createContent').html(data);
      },
      error: function (error) {
        console.error('Error al cargar el formulario', error);
      }
    });
  });

  $('.editarGift').click(function () {
    var registroId = $(this).data('id');
    console.log(registroId);
    $.ajax({
      url: '/admin/tienda/giftcard/'+registroId+'/edit',
      method: 'GET',
      dataType: 'html',
      success: function (data) {
        $('#editContent').html(data);
      },
      error: function (error) {
        console.error('Error al cargar el formulario', error);
      }
    });
  });
</script>
@stop