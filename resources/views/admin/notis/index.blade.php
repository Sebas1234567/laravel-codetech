@extends('layout.admin')

@section('title')Listado de Notificaciones | CodeTechEvolution @stop

@section('styles')
<link href="{{ asset('admin/vendors/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@stop

@section('metas')<meta name="csrf-token" content="{{ csrf_token() }}"> @stop

@section('bred1')Admin @stop
@section('bred2')Notificaciones @stop

@section('contenido')
<div class="card border-top-secondary border-top-3 mb-4">
  <div class="card-header d-flex align-items-center">
    <i class="fa-duotone fa-bell" style="font-size: 1.2rem;"></i>
    <strong class="ms-2">Listado de Notificaciones</strong>
  </div>
  <div class="card-body">
    <div class="tab-content rounded-bottom">
      <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
        <table class="table table-striped table-hover border datatable">
          <thead>
            <tr>
              <th>Id</th>
              <th>Titulo</th>
              <th>Descripción</th>
              <th>Icono</th>
              <th>Estado</th>
              <th>Toast</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($notis as $not)
              <tr class="align-middle">
                <td>{{ $not->id }}</td>
                <td>{{ $not->titulo }}</td>
                <td>{{ $not->descripcion }}</td>
                <td><i class="fa-duotone {{ $not->icono }} {{ $not->color }}" style="font-size: 1.2rem;"></i></td>
                <td>
                  @if ($not->visto)
                    <span class="badge bg-success-gradient">Visto</span>
                  @else
                    <span class="badge bg-danger-gradient">No Visto</span>
                  @endif
                </td>
                <td>
                  @if ($not->toast)
                    <span class="badge bg-danger-gradient">No Visto</span>
                  @else
                    <span class="badge bg-success-gradient">Visto</span>
                  @endif
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
@stop