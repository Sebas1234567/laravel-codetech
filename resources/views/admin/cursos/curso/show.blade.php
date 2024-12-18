@extends('layout.admin')

@section('title')Detalle de Cursos | CodeTechEvolution @stop

@section('styles')
<link href="{{ asset('admin/vendors/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('admin/videos/styles.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('admin/magnific-popup/css/magnific-popup.css') }}">
<style>
  .card-detail {
    height: 200px;
    overflow: hidden;
    position: relative;
  }
  .card-img {
    width: 100%;
    height: auto;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
  .card-img-overlay{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
  }
  .formL{
    display: contents;
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
    <strong class="ms-2">Detalle de Cursos</strong>
  </div>
  <div class="card-body">
    <div class="tab-content rounded-bottom">
      <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
        <div class="card card-detail text-bg-dark mb-3">
          <img src="/storage/files/{{ $curso->imagen }}" class="card-img" alt="{{ $curso->titulo }}">
          <div class="card-img-overlay">
            <h3 class="card-title">{{ $curso->titulo }}</h3>
            <h5 class="card-text">{{ $curso->descripcion }}</h5>
          </div>
        </div>
        <div class="d-flex">
          <h3>Lecciones</h3>
          <button type="button" class="btn btn-secondary ms-2 mb-3" id="crearLec" data-coreui-toggle="modal" data-coreui-target="#crearLeccion" data-id="{{ $curso->id }}">
            <i class="fa-regular fa-circle-plus"></i>
            Nueva Lección
          </button>
        </div>
        @if ($errors->all())
        <div class="alert alert-danger" role="alert">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
        @foreach ($lecciones as $lec)
        <div class="card text-center mb-4">
          <div class="card-header">
            {{ $lec->categoria }}
          </div>
          <div class="card-body">
            <h5 class="card-title">{{ $lec->titulo }}</h5>
            <p class="card-text">{{ $lec->descripcion }}</p>
            <a href="/vv/c/{{ $lec->video }}" class="btn btn-primary popup-youtube" id="popup-1"><i class="fa-duotone fa-play" style="margin-right: 8px"></i>Ver video</a>
          </div>
          <div class="card-footer text-body-secondary">
            <i class="fa-duotone fa-file-arrow-down" style="margin-right: 5px"></i>
            @if ($lec->recursos)
            @php
                $arrayValores = explode(';', $lec->recursos);
                $cantidadValores = count($arrayValores);
            @endphp
            {{ $cantidadValores }}
            @else
            0 
            @endif recursos descargables
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@stop

@section('modals')
<div class="modal fade" id="crearLeccion" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="crearLeccionLabel" aria-hidden="true">
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
            url: '/admin/cursos/curso/' + registroId,
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
  $('#crearLec').click(function () {
    var registroId = $(this).data('id');
    $.ajax({
      url: '/admin/cursos/leccion/create/'+registroId,
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