@extends('layout.admin')

@section('title')Listado de Cursos | CodeTechEvolution @stop

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

@section('bred1')Cursos @stop
@section('bred2')Cursos @stop

@section('contenido')
<div class="card border-top-secondary border-top-3 mb-4">
  <div class="card-header d-flex align-items-center">
    <i class="fa-duotone fa-graduation-cap" style="font-size: 1.2rem;"></i>
    <strong class="ms-2">Listado de Cursos</strong>
    <a href="{{ route('admin.cursos.curso.create') }}" class="btn btn-secondary ms-2">
      <i class="fa-regular fa-circle-plus"></i>
      Nuevo
    </a>
  </div>
  <div class="card-body">
    <div class="tab-content rounded-bottom">
      <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
        <div class="row row-cols-1 row-cols-md-3 g-4">
          @foreach ($cursos as $cur)
          <div class="col">
            <div class="card h-100">
              <img src="/storage/files/{{ $cur->imagen }}" class="card-img-top" alt="{{ $cur->titulo }}">
              <div class="row g-2">
                <div class="col-md-12">
                  @if ($cur->estado)
                    <span class="badge bg-success-gradient mx-2 mt-2">Activo</span>
                  @else
                    <span class="badge bg-danger-gradient mx-2 mt-2">Inactivo</span>
                  @endif
                </div>
              </div>
              <div class="card-body">
                <h5 class="card-title">{{ $cur->titulo }}</h5>
                <div class="row align-items-start">
                  <div class="col">
                    <p class="card-text"><i class="fa-duotone fa-tags" style="margin-right: 5px"></i>  {{ $cur->categoria }}</p>
                  </div>
                  @php
                    $horas = floor($cur->duracion / 3600);
                    $minutos = floor(($cur->duracion % 3600) / 60);
                    $segundos = $cur->duracion % 60;
                    $horas = str_pad($horas, 2, '0', STR_PAD_LEFT);
                    $minutos = str_pad($minutos, 2, '0', STR_PAD_LEFT);
                    $segundos = str_pad($segundos, 2, '0', STR_PAD_LEFT);
                  @endphp
                  <div class="col">
                    <p class="card-text"><i class="fa-duotone fa-clock-rotate-left" style="margin-right: 5px"></i>  {{ $horas }}:{{ $minutos }}:{{ $segundos }}</p>
                  </div>
                </div>
                <div class="row align-items-start">
                  <div class="col">
                    <p class="card-text"><i class="fa-duotone fa-clapperboard-play" style="margin-right: 5px"></i>  {{ $cur->cantidad_clases }} clases</p>
                  </div>
                  <div class="col">
                    <p class="card-text"><i class="fa-duotone fa-file-arrow-down" style="margin-right: 5px"></i>  {{ $cur->cantidad_recursos }} recursos</p>
                  </div>
                </div>
                <div class="row align-items-start">
                  <div class="col">
                    <p class="card-text"><i class="fa-duotone fa-trophy" style="margin-right: 5px"></i>  @if ($cur->certificado)Certificado de finalización @else No certificado de finalización @endif</p>
                  </div>
                  <div class="col">
                    <p class="card-text"><i class="fa-duotone fa-money-bill" style="margin-right: 5px"></i>  S/.{{ $cur->precio }}</p>
                  </div>
                </div>
                <div class="row align-items-start">
                  <p class="card-text"><i class="fa-duotone fa-calendars" style="margin-right: 5px"></i>  {{ \Carbon\Carbon::parse($cur->fecha_publicacion)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</p>
                </div>
                <p class="card-text"><i class="fa-duotone fa-comment-lines" style="margin-right: 5px"></i>  {{ $cur->descripcion }}</p>
              </div>
              <div class="card-footer">
                <div class="btn-group" role="group" aria-label="Opciones">
                  <a href="{{ route('admin.cursos.curso.show',['curso'=>$cur->id]) }}" class="btn btn-info"><i class="fa-duotone fa-eye"></i></a>
                  <a href="{{ route('admin.cursos.curso.edit',['curso'=>$cur->id]) }}" class="btn btn-warning"><i class="fa-duotone fa-pen-to-square"></i></a>
                  <button type="button" class="btn btn-danger delete" data-id="{{ $cur->id }}"><i class="fa-solid fa-trash-can"></i></button>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        <div class="row mt-5">
          <nav aria-label="pag-videos">
            <ul class="pagination justify-content-center">
              <li class="page-item @if ($cursos->onFirstPage())disabled @endif">
                <a class="page-link" href="{{ $cursos->previousPageUrl() }}">Anterior</a>
              </li>

              @for ($i=1; $i < $cursos->lastPage()+1; $i++)
              <li class="page-item @if ($i == $cursos->currentPage())active @endif" @if ($i == $cursos->currentPage())aria-current="page"@endif>
                <a class="page-link" href="{{ $cursos->url($i) }}">{{ $i }}</a>
              </li>
              @endfor

              <li class="page-item @if ($cursos->lastPage() == $cursos->currentPage())disabled @endif">
                <a class="page-link" href="{{ $cursos->nextPageUrl() }}">Siguiente</a>
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
@stop