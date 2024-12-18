@extends('layout.admin')

@section('title')Listado de Entradas | CodeTechEvolution @stop

@section('styles')
<link href="{{ asset('admin/vendors/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('admin/magnific-popup/css/magnific-popup.css') }}">
<style>
  .btn-group{
    display: flex;
  }
  .badge{
    display: flex;
    justify-content: center;
    align-items: center;
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
    <strong class="ms-2">Listado de Entradas</strong>
    <a href="{{ route('admin.blog.entradas.create') }}" class="btn btn-secondary ms-2">
      <i class="fa-regular fa-circle-plus"></i>
      Nuevo
    </a>
  </div>
  <div class="card-body">
    <div class="tab-content rounded-bottom">
      <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
        <div class="row row-cols-1 row-cols-md-3 g-4">
          @foreach ($entradas as $ent)
          <div class="col">
            <div class="card h-100">
              <img src="/storage/files/{{ $ent->imagen }}" class="card-img-top" alt="{{ $ent->titulo }}">
              <div class="row g-2">
                <div class="col-md-6">
                  @if ($ent->estado)
                    <span class="badge bg-success-gradient mx-2 mt-2">Activo</span>
                  @else
                    <span class="badge bg-danger-gradient mx-2 mt-2">Inactivo</span>
                  @endif
                </div>
                <div class="col-md-6">
                  @if ($ent->publicado)
                    <span class="badge bg-success-gradient mx-2 mt-2">Publicado</span>
                  @else
                    <span class="badge bg-danger-gradient mx-2 mt-2">No publicado</span>
                  @endif
                </div>
              </div>
              <div class="card-body">
                <h5 class="card-title">{{ $ent->titulo }}</h5>
                <p class="card-text"><i class="fa-duotone fa-user" style="margin-right: 5px"></i>  {{ $ent->autor }}</p>
                <p class="card-text"><i class="fa-duotone fa-tags" style="margin-right: 5px"></i>  {{ $ent->categorias }}</p>
                <p class="card-text"><i class="fa-duotone fa-calendars" style="margin-right: 5px"></i>  {{ \Carbon\Carbon::parse($ent->fecha_publicacion)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</p>
                <p class="card-text"><i class="fa-duotone fa-comment-lines" style="margin-right: 5px"></i>  {{ $ent->descripcion }}</p>
              </div>
              <div class="card-footer">
                <div class="btn-group" role="group" aria-label="Opciones">
                  <a href="/vv/e/{{ $ent->video }}" class="btn btn-info popup-youtube" id="popup-1"><i class="fa-duotone fa-play"></i></a>
                  <a href="{{ route('admin.blog.entradas.edit',['entrada'=>$ent->id]) }}" class="btn btn-warning"><i class="fa-duotone fa-pen-to-square"></i></a>
                  <button type="button" class="btn btn-danger delete" data-id="{{ $ent->id }}"><i class="fa-solid fa-trash-can"></i></button>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        <div class="row mt-5">
          <nav aria-label="pag-videos">
            <ul class="pagination justify-content-center">
              <li class="page-item @if ($entradas->onFirstPage())disabled @endif">
                <a class="page-link" href="{{ $entradas->previousPageUrl() }}">Anterior</a>
              </li>

              @for ($i=1; $i < $entradas->lastPage()+1; $i++)
              <li class="page-item @if ($i == $entradas->currentPage())active @endif" @if ($i == $entradas->currentPage())aria-current="page"@endif>
                <a class="page-link" href="{{ $entradas->url($i) }}">{{ $i }}</a>
              </li>
              @endfor

              <li class="page-item @if ($entradas->lastPage() == $entradas->currentPage())disabled @endif">
                <a class="page-link" href="{{ $entradas->nextPageUrl() }}">Siguiente</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
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
            url: '/admin/blog/entradas/' + registroId,
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