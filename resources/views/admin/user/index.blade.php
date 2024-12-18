@extends('layout.admin')

@section('title')Listado de Usuarios | CodeTechEvolution @stop

@section('styles')
<link href="{{ asset('admin/vendors/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<style>
  .in-pass-s{
    border-right: none;
  }
  .btn-pass-s{
    border-left: none;
    padding-top: 3px;
  }
  .btn-pass-s:hover{
    background: #fff;
  }
</style>
@stop

@section('metas')<meta name="csrf-token" content="{{ csrf_token() }}"> @stop

@section('bred1')Admin @stop
@section('bred2')Usuarios @stop

@section('contenido')
<div class="card border-top-secondary border-top-3 mb-4">
  <div class="card-header d-flex align-items-center">
    <i class="fa-duotone fa-tags" style="font-size: 1.2rem;"></i>
    <strong class="ms-2">Listado de Usuarios</strong>
    <button type="button" class="btn btn-secondary ms-2" id="crearUsu" data-coreui-toggle="modal" data-coreui-target="#crearUsuario">
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
        <table class="table table-striped table-hover border datatable">
          <thead>
            <tr>
              <th>Id</th>
              <th>Nombre</th>
              <th>Email</th>
              <th>Imagen</th>
              <th>Estado</th>
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($usuarios as $usu)
              <tr class="align-middle">
                <td>{{ $usu->id }}</td>
                <td>{{ $usu->name }}</td>
                <td>{{ $usu->email }}</td>
                <td>
                  <div class="avatar avatar-lg">
                    <img class="avatar-img" src="/storage/files/{{ $usu->imagen }}" alt="{{ $usu->name }}">
                  </div>
                </td>
                <td>
                  @if ($usu->estado)
                    <span class="badge bg-success-gradient">Activo</span>
                  @else
                    <span class="badge bg-danger-gradient">Inactivo</span>
                  @endif
                </td>
                <td>
                  <button class="btn btn-warning me-2 editarUsu" type="button" data-id="{{ $usu->id }}" data-coreui-toggle="modal" data-coreui-target="#editarUsuario">
                    <i class="fa-duotone fa-pen-to-square"></i>
                  </button>
                  <button class="btn btn-danger delete" type="button" data-id="{{ $usu->id }}">
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

@section('modals')
<div class="modal fade" id="crearUsuario" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="crearUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content" id="createContent">
    </div>
  </div>
</div>
<div class="modal fade" id="editarUsuario" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="editarUsuarioLabel" aria-hidden="true">
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
            url: '/admin/usuarios/' + registroId,
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
  $('#crearUsu').click(function () {
    $.ajax({
      url: '/admin/usuarios/create',
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

  $('.editarUsu').click(function () {
    var registroId = $(this).data('id');
    $.ajax({
      url: '/admin/usuarios/'+registroId+'/edit',
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