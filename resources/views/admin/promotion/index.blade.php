@extends('layout.admin')

@section('title')Listado de Promociones | CodeTechEvolution @stop

@section('styles')
<link href="{{ asset('admin/vendors/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@stop

@section('metas')<meta name="csrf-token" content="{{ csrf_token() }}"> @stop

@section('bred1')Admin @stop
@section('bred2')Promociones @stop

@section('contenido')
<div class="card border-top-secondary border-top-3 mb-4">
  <div class="card-header d-flex align-items-center">
    <i class="fa-duotone fa-badge-percent" style="font-size: 1.2rem;"></i>
    <strong class="ms-2">Listado de Promociones</strong>
    <a href="{{ route('admin.promocion.promociones.create') }}" class="btn btn-secondary ms-2">
      <i class="fa-regular fa-circle-plus"></i>
      Nuevo
    </a>
  </div>
  <div class="card-body">
    <div class="tab-content rounded-bottom">
      <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
        <table class="table table-striped table-hover border datatable">
          <thead>
            <tr>
              <th>Id</th>
              <th>Titulo</th>
              <th>Descripcion</th>
              <th>Fecha Fin</th>
              <th>Porcentaje</th>
              <th>Estado</th>
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($promociones as $pro)
              <tr class="align-middle">
                <td>{{ $pro->id }}</td>
                <td>{{ $pro->titulo }}</td>
                <td>{{ $pro->descripcion }}</td>
                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pro->fecha_fin)->format('d/m/Y') }}</td>
                <td>{{ $pro->porcentaje }}%</td>
                <td>
                  @if ($pro->estado)
                    <span class="badge bg-success-gradient">Activo</span>
                  @else
                    <span class="badge bg-danger-gradient">Inactivo</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('admin.promocion.promociones.edit',['promocione'=>$pro->id]) }}" class="btn btn-warning me-2">
                    <i class="fa-duotone fa-pen-to-square"></i>
                  </a>
                  <button class="btn btn-danger delete" type="button" data-id="{{ $pro->id }}">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
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
            url: '/admin/promociones/' + registroId,
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