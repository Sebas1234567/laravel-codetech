@extends('layout.admin')

@section('title')Compra - {{ $compra->n_pedido }} | CodeTechEvolution @stop

@section('styles')
<style>
  .img-info{
    border-radius: 5px;
    border: 1px solid #e5e5e5;
    padding: 5px 10px;
    box-shadow: 0px 0px 10px -5px rgba(0, 0, 0, 0.5);
    margin-left: 10px;
  }
  .img-info img{
    width: 40px;
  }
  .method{
    display: flex;
    align-items: center;
    margin-top: 3px;
  }
  .left{
    text-align: left;
  }
  .center{
    text-align: center;
  }
  .right{
    text-align: right;
  }
</style>
@stop

@section('metas')<meta name="csrf-token" content="{{ csrf_token() }}"> @stop

@section('bred1')Admin @stop
@section('bred2')Compras @stop

@section('contenido')
<div class="card">
  <div class="card-header d-flex align-items-center">
    <i class="fa-duotone fa-credit-card me-2" style="font-size: 1.2rem"></i>
    Compra: <strong style="margin-left: 3px">{{ $compra->n_pedido }}</strong>
    <a class="btn btn-sm btn-info ms-2 d-print-none" href="{{ route('compras.report',['compra'=>$compra->id]) }}">
      <i class="fa-duotone fa-print me-1"></i> Imprimir
    </a>
  </div>
  <div class="card-body">
    <div class="row mb-4">
      <div class="col-sm-12">
        <h6 class="mb-3">Detalles:</h6>
        <div>Pedido: <strong style="margin-left: 3px">{{ $compra->n_pedido }}</strong></div>
        <div>{{ \Carbon\Carbon::parse($compra->fecha_compra)->locale('es')->format('F j, Y') }}</div>
        <div>Nombre Usuario: {{ $compra->name }}</div>
        <div class="method">Método de Pago: <strong style="margin-left: 10px">{{ ucfirst($compra->metodo_pago) }}</strong>
          <div class="img-info">
            <img src="@if ($compra->metodo_pago == 'tarjeta') {{ asset('admin/assets/img/card.png') }}@else {{ asset('admin/assets/img/paypal-logo.png') }}@endif" alt="@if ($compra->metodo_pago == 'tarjeta') Tarjeta @else PayPal @endif">
          </div>
        </div>
      </div>
      <!-- /.col-->
    </div>
    <!-- /.row-->
    <div class="table-responsive-sm">
      <table class="table table-striped">
        <thead>
          <tr>
            <th class="center">#</th>
            <th>Item</th>
            <th class="center">Cantidad</th>
            <th class="right">Precio Unitario</th>
            <th class="right">Descuento</th>
            <th class="right">SubTotal</th>
          </tr>
        </thead>
        <tbody>
          @php
            $subtotal = 0.00;
            $descuento = 0.00;
          @endphp
          @foreach ($detalle as $item)
          @php
            $descuento += $item->descuento
          @endphp
          @if($item->producto) @php $subtotal += $item->precio_p @endphp @else @php $subtotal += $item->precio_c @endphp @endif
          <tr>
            <td class="center">{{ $loop->iteration }}</td>
            <td class="left">@if($item->producto) Producto: {{ $item->producto }}@else Curso: {{ $item->curso }} @endif</td>
            <td class="center">{{ $item->cantidad }}</td>
            <td class="right">S/. @if($item->producto) {{ $item->precio_p }}@else {{ $item->precio_c }} @endif</td>
            <td class="right">S/. {{ $item->descuento }}</td>
            <td class="right">S/. {{ $item->subtotal }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="row">
      <div class="col-lg-4 col-sm-5"></div>
      <div class="col-lg-4 col-sm-5 ms-auto">
        <table class="table table-clear">
          <tbody>
            <tr>
              <td class="left"><strong>Subtotal</strong></td>
              <td class="right">S/. @if(str_contains($subtotal,'.')) 
                  @php
                    $puntoPosicion = strpos($subtotal, '.');
                    $caracteresDespuesDelPunto = strlen(substr($subtotal, $puntoPosicion + 1));
                  @endphp
                  @if ($caracteresDespuesDelPunto == 1)
                    {{ $subtotal }}0
                  @else
                    {{ $subtotal }}
                  @endif
                @else {{ $subtotal }}.00 @endif</td>
            </tr>
            <tr>
              <td class="left"><strong>Descuento</strong></td>
              <td class="right">S/. 
                @if(str_contains($descuento,'.')) 
                  @php
                    $puntoPosicion = strpos($descuento, '.');
                    $caracteresDespuesDelPunto = strlen(substr($descuento, $puntoPosicion + 1));
                  @endphp
                  @if ($caracteresDespuesDelPunto == 1)
                    {{ $descuento }}0
                  @else
                    {{ $descuento }}
                  @endif
                @else {{ $descuento }}.00 @endif</td>
            </tr>
            <tr>
              <td class="left"><strong>Total</strong></td>
              <td class="right"><strong>S/. {{ $compra->total }}</strong></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-2 col-sm-2">
        <a class="btn btn-secondary" href="{{ route('admin.compras.compras.index') }}"><i class="fa-duotone fa-turn-left" style="margin-right: 5px"></i> Volver</a>
      </div>
    </div>
  </div>
</div>
@stop

@section('scripts')
<script src="{{ asset('admin/vendors/jquery/js/jquery.min.js') }}"></script>
@stop