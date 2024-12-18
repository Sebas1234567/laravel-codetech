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
                    Una vez finalice su compra, <strong>descargue su proyecto desde el botón de descarga</strong>, también se le enviarán los <strong>enlaces de descarga</strong> a la direccion de <strong>correo electrónico</strong> que proporcionó al momento de la compra en esta Página, si tuvo algún inconveniente con su compra escribeme a <strong>code.tech.evolution@gmail.com</strong>.
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="checkout-accordion-wrap">
                    <div class="accordion" id="accordionExample">
                        <div class="card single-accordion">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Detalles de facturación
                                    </button>
                                </h5>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="billing-address-form">
                                        <ul>
                                            <li>
                                                <div class="info">
                                                    <p>Nombre: </p>{{ $usuario->name }}
                                                </div>
                                            </li>
                                            <li>
                                                <div class="info">
                                                    <p>Correo electrónico: </p>{{ $usuario->email }}
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                            @php
                                $descuentos = 0;
                                $subtotal = 0;
                            @endphp
                            @foreach ($detalles as $item)
                                @php
                                    $descuentos += $item->descuento;
                                    $subtotal += $item->precio_unitario;
                                @endphp
                                @if ($item->curso)
                                    @foreach ($cursos as $cur)
                                        @if ($cur->id == $item->curso)
                                        <tr>
                                            <td>{{ $cur->titulo }}</td>
                                            <td>${{ $item->precio_unitario }}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                @elseif ($item->producto)
                                    @foreach ($productos as $prod)
                                        @if ($prod->id == $item->producto)
                                        <tr>
                                            <td>{{ $prod->titulo }}</td>
                                            <td>${{ $item->precio_unitario }}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                        <tbody class="checkout-details">
                            <tr>
                                <td>Subtotal</td>
                                <td>${{ $subtotal }}</td>
                            </tr>
                            <?php $total = $subtotal - $descuentos; ?>
                            <tr>
                                <td>Total</td>
                                <td>${{ $total }}</td>
                                <input type="hidden" name="total-price" id="total-price" value="{{ $total }}">
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="order-details-payment">
                    <div class="payment-methods">
                        <div class="form-check-nf">
                            @if ($compra->metodo_pago == 'paypal')
                            <p>PayPal Express</p>
                            <div class="img-info">
                                <img src="{{ asset('web/assets/img/paypal-logo.png') }}" alt="PayPal">
                            </div>
                            @else
                            <p>Tarjeta de Debito o Crédito</p>
                            <div class="img-info">
                                <img src="{{ asset('web/assets/img/card.png') }}" alt="Tarjeta">
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="payment-info">
                        <p>Tus datos personales se utilizarán para procesar tu pedido, mejorar tu experiencia en esta web y otros propósitos descritos en nuestra <a href="{{ route('priv') }}" target="_blank">política de privacidad</a>.</p>
                    </div>
                </div>
                <div class="confirm-button confirm-pay">
                    <button type="button" onclick="redireccion()">Realizar pedido</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end check out section -->
@stop

@section('scripts')
<script>
    function redireccion() {
        window.location.href = "{{ route('checkdown',['id'=>$compra->id]) }}";
    }
</script>
@stop