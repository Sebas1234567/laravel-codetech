@extends('layout.admin')

@section('title')Listado de Productos | CodeTechEvolution @stop

@section('styles')
<link href="{{ asset('admin/vendors/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
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

@section('bred1')Tienda @stop
@section('bred2')Productos @stop

@section('contenido')
<div class="card border-top-secondary border-top-3 mb-4">
  <div class="card-header d-flex align-items-center">
    <i class="fa-duotone fa-basket-shopping" style="font-size: 1.2rem;"></i>
    <strong class="ms-2">Listado de Productos</strong>
    <a href="{{ route('admin.tienda.productos.create') }}" class="btn btn-secondary ms-2">
      <i class="fa-regular fa-circle-plus"></i>
      Nuevo
    </a>
  </div>
  <div class="card-body">
    <div class="tab-content rounded-bottom">
      <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
        <div class="row row-cols-1 row-cols-md-3 g-4">
          @foreach ($productos as $prod)
          <div class="col">
            <div class="card h-100">
              <div id="cardSlider" class="carousel slide card-img-top" data-coreui-ride="true">
                <div class="carousel-indicators">
                  <button type="button" data-coreui-target="#cardSlider" data-coreui-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                  @php
                    $galeria = explode(';', $prod->galeria_imagenes);
                    $slide = 1;
                  @endphp
                  @foreach ($galeria as $img)
                    @if(stripos($img, '&100x100') === false)
                    <button type="button" data-coreui-target="#cardSlider" data-coreui-slide-to="{{ $slide }}" aria-label="Slide {{ $slide + 1 }}"></button>
                    @php
                      $slide++;
                    @endphp
                    @endif
                  @endforeach
                </div>
                <div class="carousel-inner card-img-top">
                  <div class="carousel-item card-img-top active" data-coreui-interval="2000">
                    <img src="/storage/files/{{ $prod->imagen }}" class="d-block w-100 card-img-top" alt="{{ $prod->imagen }}">
                  </div>
                  @foreach ($galeria as $img)
                    @if(stripos($img, '&100x100') === false)
                    <div class="carousel-item card-img-top" data-coreui-interval="2000">
                      <img src="/storage/files/{{ $img }}" class="d-block w-100 card-img-top" alt="{{ $img }}">
                    </div>
                    @endif
                  @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-coreui-target="#cardSlider" data-coreui-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-coreui-target="#cardSlider" data-coreui-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
              <div class="row g-2">
                <div class="col-md-6">
                  @if ($prod->estado)
                    <span class="badge bg-success-gradient mx-2 mt-2">Activo</span>
                  @else
                    <span class="badge bg-danger-gradient mx-2 mt-2">Inactivo</span>
                  @endif
                </div>
                <div class="col-md-6">
                  @if ($prod->publicado)
                    <span class="badge bg-success-gradient mx-2 mt-2">Publicado</span>
                  @else
                    <span class="badge bg-danger-gradient mx-2 mt-2">No publicado</span>
                  @endif
                </div>
              </div>
              <div class="card-body">
                <h5 class="card-title">{{ $prod->titulo }}</h5>
                <p class="card-text"><i class="fa-duotone fa-barcode" style="margin-right: 5px"></i>  {{ $prod->sku }}</p>
                <p class="card-text"><i class="fa-duotone fa-tags" style="margin-right: 5px"></i>  {{ $prod->categorias }}</p>
                <p class="card-text"><i class="fa-duotone fa-calendars" style="margin-right: 5px"></i>  {{ \Carbon\Carbon::parse($prod->fecha_publicacion)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</p>
                <p class="card-text"><i class="fa-duotone fa-duotone fa-money-bill" style="margin-right: 5px"></i>  S/.{{ $prod->precio }}</p>
              </div>
              <div class="card-footer">
                <div class="btn-group" role="group" aria-label="Opciones">
                  <a href="/storage/files/{{ $prod->archivo }}" class="btn btn-info" download><i class="fa-duotone fa-download"></i></a>
                  <a href="{{ route('admin.tienda.productos.edit',['producto'=>$prod->id]) }}" class="btn btn-warning"><i class="fa-duotone fa-pen-to-square"></i></a>
                  <button type="button" class="btn btn-danger delete" data-id="{{ $prod->id }}"><i class="fa-solid fa-trash-can"></i></button>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        <div class="row mt-5">
          <nav aria-label="pag-videos">
            <ul class="pagination justify-content-center">
              <li class="page-item @if ($productos->onFirstPage())disabled @endif">
                <a class="page-link" href="{{ $productos->previousPageUrl() }}">Anterior</a>
              </li>

              @for ($i=1; $i < $productos->lastPage()+1; $i++)
              <li class="page-item @if ($i == $productos->currentPage())active @endif" @if ($i == $productos->currentPage())aria-current="page"@endif>
                <a class="page-link" href="{{ $productos->url($i) }}">{{ $i }}</a>
              </li>
              @endfor

              <li class="page-item @if ($productos->lastPage() == $productos->currentPage())disabled @endif">
                <a class="page-link" href="{{ $productos->nextPageUrl() }}">Siguiente</a>
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
            url: '/admin/tienda/productos/' + registroId,
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
@stop