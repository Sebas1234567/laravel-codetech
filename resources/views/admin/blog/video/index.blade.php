@extends('layout.admin')

@section('title')Listado de Videos | CodeTechEvolution @stop

@section('styles')
<link href="{{ asset('admin/vendors/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('admin/videos/styles.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('admin/magnific-popup/css/magnific-popup.css') }}">
<style>
  .modal-content form{
    display: contents;
  }
  .card-img-overlay{
    background: rgba(0,0,0,.3);
  }
  .badge-video{
    position: absolute;
    bottom: 13px;
  }
  .btn.delete{
    position: absolute;
    bottom: 13px;
    right: 13px;
  }
</style>
@stop

@section('metas')<meta name="csrf-token" content="{{ csrf_token() }}"> @stop

@section('bred1')Blog @stop
@section('bred2')Videos @stop

@section('contenido')
<div class="card border-top-secondary border-top-3 mb-4">
  <div class="card-header d-flex align-items-center">
    <i class="fa-duotone fa-video" style="font-size: 1.2rem;"></i>
    <strong class="ms-2">Listado de Videos</strong>
    <button type="button" class="btn btn-secondary ms-2" id="crearVid" data-coreui-toggle="modal" data-coreui-target="#crearVideo">
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
        <div class="row row-cols-1 row-cols-md-3 g-4">
          @foreach ($videos as $vid)
            <div class="col">
              <div class="card text-bg-dark">
                <img src="/storage/files/{{ $vid->poster }}" class="card-img-top" alt="{{ $vid->nombre }}">
          
                <div class="card-img-overlay">
                  <h5 class="card-title"><a href="/vv/e/{{ $vid->id }}" class="text-bg-dark popup-youtube" id="popup-1" style="--cui-bg-opacity:0;text-decoration:none;">{{ $vid->nombre }}</a></h5>
                  <p class="card-text"><strong>Calidades: </strong>{{ $vid->calidad }}</p>
                  <p class="card-text"><strong>Subtitulos: </strong>
                    @foreach (explode(';',$vid->subtitulos) as $subtitulo)
                      @php
                        preg_match('/vtt\/subtitulos_\w{2}_(\w+)\.vtt/', $subtitulo, $matches);
                        $idioma = isset($matches[1]) ? $matches[1] : '-';
                      @endphp
                      {{ $idioma }}@if (!$loop->last),@endif
                    @endforeach
                  </p>
                  @if ($vid->estado)
                    <span class="badge bg-success-gradient badge-video">Activo</span>
                  @else
                    <span class="badge bg-danger-gradient badge-video">Inactivo</span>
                  @endif
                  <button class="btn btn-danger delete" type="button" data-id="{{ $vid->id }}">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <div class="row mt-5">
          <nav aria-label="pag-videos">
            <ul class="pagination justify-content-center">
              <li class="page-item @if ($videos->onFirstPage())disabled @endif">
                <a class="page-link" href="{{ $videos->previousPageUrl() }}">Anterior</a>
              </li>

              @for ($i=1; $i < $videos->lastPage()+1; $i++)
              <li class="page-item @if ($i == $videos->currentPage())active @endif" @if ($i == $videos->currentPage())aria-current="page"@endif>
                <a class="page-link" href="{{ $videos->url($i) }}">{{ $i }}</a>
              </li>
              @endfor

              <li class="page-item @if ($videos->lastPage() == $videos->currentPage())disabled @endif">
                <a class="page-link" href="{{ $videos->nextPageUrl() }}">Siguiente</a>
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
<div class="modal fade" id="crearVideo" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="crearVideoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content" id="createContent">
    </div>
  </div>
</div>
@stop

@section('scripts')
<script src="{{ asset('admin/vendors/jquery/js/jquery.min.js') }}"></script>
<script src="{{ asset('admin/vendors/datatables.net/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('admin/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/js/datatables.js') }}"></script>
<script src="{{ asset('admin/magnific-popup/js/jquery.magnific-popup.min.js') }}"></script>
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
            url: '/admin/blog/video/' + registroId,
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
  $('#crearVid').click(function () {
    $.ajax({
      url: '/admin/blog/video/create',
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

  $('.editarVid').click(function () {
    var registroId = $(this).data('id');
    $.ajax({
      url: '/admin/blog/video/'+registroId+'/edit',
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
<script>
  $('.popup-youtube').magnificPopup({
      disableOn: 700,
      type: 'iframe',
      mainClass: 'mfp-fade',
      removalDelay: 160,
      preloader: true,
      fixedContentPos: false
  });

  // light box
  $('.image-popup-vertical-fit').magnificPopup({
      type: 'image',
      closeOnContentClick: true,
      mainClass: 'mfp-img-mobile',
      image: {
          verticalFit: true
      }
  });
</script>
@stop