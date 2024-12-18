@extends('layout.web')

@section('title')Finalizar Compra @stop

@section('styles')
@stop

@section('content')
<!-- breadcrumb-section -->
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h1>Finalizar Compra</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- check out section -->
<div class="checkout-section mt-2 mb-5">
    <div class="container">
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="alert alert-success alert-shop-success" role="alert">
                    Una vez finalice su compra, <strong>descargue su proyecto desde el botón de descarga</strong>, también se le enviarán los <strong>enlaces de descarga</strong> a la direccion de <strong>correo electrónico</strong> que proporcionó al momento de la compra en esta Página, si tuvo algún inconveniente con su compra escribeme a <strong>codetechevolution@gmail.com</strong>.
                </div>
                <div class="alert alert-primary">
                    Gracias. Tu pedido se ha recibido
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="info-details-payment">
                    <div class="card-payment-details">
                        <span class="info-title">NÚMERO DE PEDIDO:</span>
                        <p class="info-text">{{ $compra->n_pedido }}</p>
                    </div>
                    <div class="card-payment-details">
                        <span class="info-title">FECHA:</span>
                        <p class="info-text">{{ \Carbon\Carbon::parse($compra->fecha_compra)->locale('es')->isoFormat('DD MMMM, YYYY') }}</p>
                    </div>
                    <div class="card-payment-details">
                        <span class="info-title">TOTAL:</span>
                        <p class="info-text">${{ $compra->total }}</p>
                    </div>
                    <div class="card-payment-details">
                        <span class="info-title">MÉTODO DE PAGO:</span>
                        @if ($compra->metodo_pago == 'paypal')
                        <p class="info-text">PayPal Express</p>
                        @else
                        <p class="info-text">Tarjeta de Débito o Crédito</p>
                        @endif
                    </div>
                </div>
            </div>
            @if ($detallesP)
            <div class="col-lg-12 mb-5">
                <div class="cart-table-wrap">
                    <h3>Productos</h3>
                    <table class="cart-table download-table">
                        <thead class="cart-table-head">
                            <tr class="table-head-row">
                                <th class="product-name">Producto</th>
                                <th class="product-cdownload">Descargas restantes</th>
                                <th class="product-expire">Caduca</th>
                                <th class="product-button">Descargar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detallesP as $prod)
                                @foreach ($productos as $pd)
                                    @if ($pd->id == $prod->producto)
                                    <tr class="table-body-row">
                                        <td class="product-name">
                                            <a href="/storage/files/{{ $pd->archivo }}" download>{{ $pd->titulo }}</a>
                                        </td>
                                        <td class="product-cdownload">&#x221e;</td>
                                        <td class="product-expire">Nunca</td>
                                        <td class="product-button">
                                            <div class="confirm-button download-button">
                                                <a href="/storage/files/{{ $pd->archivo }}" download>Descargar</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            @if ($detallesC)
            <div class="col-lg-12 mb-5">
                <div class="cart-table-wrap">
                    <h3>Cursos</h3>
                    <table class="cart-table download-table">
                        <thead class="cart-table-head">
                            <tr class="table-head-row">
                                <th class="product-name">Curso</th>
                                <th class="product-cdownload">Tipo de Acceso</th>
                                <th class="product-expire">Duración</th>
                                <th class="product-button">Acceder</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detallesC as $cur)
                                @foreach ($cursos as $cr)
                                    @if ($cr->id == $cur->curso)
                                    @php
                                        $horas = floor($cr->duracion / 3600);
                                        $minutos = floor(($cr->duracion % 3600) / 60);
                                        $segundos = $cr->duracion % 60;
                                        $horas = str_pad($horas, 2, '0', STR_PAD_LEFT);
                                        $minutos = str_pad($minutos, 2, '0', STR_PAD_LEFT);
                                        $segundos = str_pad($segundos, 2, '0', STR_PAD_LEFT);
                                    @endphp
                                    <tr class="table-body-row">
                                        <td class="product-name">
                                            <a href="#">{{ $cr->titulo }}</a>
                                        </td>
                                        <td class="product-cdownload">&#x221e;</td>
                                        <td class="product-expire">@if ($horas != 00){{ $horas }} horas {{ $minutos }} minutos @else {{ $minutos }} minutos {{ $segundos }} segundos @endif</td>
                                        <td class="product-button">
                                            <div class="confirm-button download-button">
                                                <a href="#">Inicar Curso</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            <div class="col-lg-6 approve-pay">
                <div class="order-details-wrap">
                    <table class="order-details check-table">
                        <thead>
                            <tr>
                                <th>Producto / Curso</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="order-details-body">
                            @foreach ($detallesP as $prod)
                                @foreach ($productos as $pd)
                                    @if ($pd->id == $prod->producto)
                                    <tr>
                                        <td>{{ $pd->titulo }}</td>
                                        <td>${{ $prod->subtotal }}</td>
                                    </tr>
                                    @endif
                                @endforeach
                            @endforeach
                            @foreach ($detallesC as $cur)
                                @foreach ($cursos as $cr)
                                    @if ($cr->id == $cur->curso)
                                    <tr>
                                        <td>{{ $cr->titulo }}</td>
                                        <td>${{ $cur->subtotal }}</td>
                                    </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                        <tbody class="checkout-details">
                            <tr>
                                <td>Subtotal</td>
                                <td>${{ $compra->total }}</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>${{ $compra->total }}</td>
                                <input type="hidden" name="total-price" id="total-price" value="{{ $compra->total }}">
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end check out section -->
@stop

@section('scripts')
@stop