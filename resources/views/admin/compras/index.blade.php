@extends('layout.admin')

@section('title')Listado de Compras | CodeTechEvolution @stop

@section('styles')
<link href="{{ asset('admin/vendors/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@stop

@section('metas')<meta name="csrf-token" content="{{ csrf_token() }}"> @stop

@section('bred1')Admin @stop
@section('bred2')Compras @stop

@section('contenido')
<div class="card border-top-secondary border-top-3 mb-4">
  <div class="card-header d-flex align-items-center">
    <i class="fa-duotone fa-credit-card" style="font-size: 1.2rem;"></i>
    <strong class="ms-2">Listado de Compras</strong>
  </div>
  <div class="card-body">
    <div class="tab-content rounded-bottom">
      <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
        <table class="table table-striped table-hover border datatable">
          <thead>
            <tr>
              <th>Id</th>
              <th>Usuario</th>
              <th>N° Pedido</th>
              <th>Fecha</th>
              <th>Metodo Pago</th>
              <th>Total</th>
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($compras as $com)
              <tr class="align-middle">
                <td>{{ $com->id }}</td>
                <td>{{ $com->name }}</td>
                <td>{{ $com->n_pedido }}</td>
                <td>{{ $com->fecha_compra }}</td>
                <td>{{ $com->metodo_pago }}</td>
                <td>{{ $com->total }}</td>
                <td>
                  <a class="btn btn-info me-2" href="{{ route('compras.report',['compra'=>$com->id]) }}">
                    <i class="fa-duotone fa-file-invoice" style="margin-right: 5px"></i>
                    Comprobante
                  </a>
                  <a class="btn btn-success" href="{{ route('admin.compras.compras.show',['compra'=>$com->id]) }}">
                    <i class="fa-duotone fa-memo-circle-info" style="margin-right: 5px"></i>
                    Detalles
                  </a>
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
@stop