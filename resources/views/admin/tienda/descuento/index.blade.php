@extends('layout.admin')

@section('title')Listado de Descuentos | CodeTechEvolution @stop

@section('styles')
<link href="{{ asset('admin/vendors/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<style>
  .codigo{
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
  }
  .val-ds{
    display: flex;
    margin-top: 5px
  }
  .ptol{
    margin-left: 5px;
    margin-bottom: 0;
  }
</style>
@stop

@section('metas')<meta name="csrf-token" content="{{ csrf_token() }}"> @stop

@section('bred1')Tienda @stop
@section('bred2')Descuentos @stop

@section('contenido')
<div class="card border-top-secondary border-top-3 mb-4">
  <div class="card-header d-flex align-items-center">
    <i class="fa-duotone fa-badge-dollar" style="font-size: 1.2rem;"></i>
    <strong class="ms-2">Listado de Descuentos</strong>
    <a href="{{ route('admin.tienda.descuento.create') }}" class="btn btn-secondary ms-2">
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
              <th>Codigo</th>
              <th>Fecha de Inicio</th>
              <th>Fecha de Fin</th>
              <th>Estado</th>
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($descuentos as $desc)
              <tr class="align-middle">
                <td>{{ $desc->id }}</td>
                <td class="codigo">
                  <span class="badge rounded-pill text-bg-dark">{{ $desc->codigo }}</span>
                  @if ($desc->tipo_cant == 'porcentaje')
                    @if ($desc->total>0)
                    <small class="val-ds">{{ $desc->cantidad }}% de descuento en {{ $desc->total }} <p class="ptol" data-coreui-toggle="tooltip" data-coreui-html="true" title="<ul> @if ($desc->total>1)@foreach ($desc->productos as $prod)<li>{{ $prod }}</li>@endforeach @else <li>{{ $desc->productos }}</li>@endif </ul>">productos</p></small>
                    @else
                    <small class="val-ds">{{ $desc->cantidad }}% de descuento en Todo</small>
                    @endif
                  @else
                    @if ($desc->total>0)
                    <small class="val-ds">S/.{{ $desc->cantidad }} de descuento en {{ $desc->total }} <p class="ptol" data-coreui-toggle="tooltip" data-coreui-html="true" title="<ul> @if ($desc->total>1)@foreach ($desc->productos as $prod)<li>{{ $prod }}</li>@endforeach @else <li>{{ $desc->productos }}</li>@endif </ul>">productos</p></small>
                    @else
                    <small class="val-ds">S/.{{ $desc->cantidad }} de descuento en Todo</small>
                    @endif
                  @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($desc->fechaInicio)->locale('es')->isoFormat('DD[-]MM[-]YYYY') }}</td>
                <td>{{ \Carbon\Carbon::parse($desc->fechaFin)->locale('es')->isoFormat('DD[-]MM[-]YYYY') }}</td>
                <td>
                  @if ($desc->activo)
                    <span class="badge bg-success-gradient">Usable</span>
                  @else
                    <span class="badge bg-danger-gradient">Inusable</span>
                  @endif

                  @if ($desc->estado)
                    <span class="badge bg-success-gradient">Activo</span>
                  @else
                    <span class="badge bg-danger-gradient">Inactivo</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('admin.tienda.descuento.edit',['descuento'=>$desc->id]) }}" class="btn btn-warning me-2 editarDesc">
                    <i class="fa-duotone fa-pen-to-square"></i>
                  </a>
                  <button class="btn btn-danger delete" type="button" data-id="{{ $desc->id }}">
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
  const exampleEl = document.querySelector('.ptol')
  const tooltip = new coreui.Tooltip(exampleEl, {
    html:true,
    placement:'right',
  })
</script>

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
            url: '/admin/tienda/descuento/' + registroId,
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