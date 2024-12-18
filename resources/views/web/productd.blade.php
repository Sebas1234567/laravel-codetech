@extends('layout.web')

@section('title'){{ $producto->titulo }} @stop

@section('styles')
<!-- photoswipe -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="{{ asset('web/assets/css/photoswipe.min.css') }}">
<link rel="stylesheet" href="{{ asset('web/assets/css/default-skin.min.css') }}">
<link rel="stylesheet" href="{{ asset('web/assets/css/photoswipe.css') }}">
<link rel="stylesheet" href="{{ asset('web/assets/css/jquery.wm-zoom-1.0.css') }}">
@stop

@section('content')
<!-- breadcrumb-section -->
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- single product -->
<div class="single-product mt-5 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav-prod">
                    <li class="nav-prod-item active">
                        <a href="{{ route('index') }}" class="nav-prod-link active">Inicio</a>
                    </li>
                    <li class="nav-prod-item active">
                        <a href="#" class="nav-prod-link active">{{ $categoria->nombre }}</a>
                    </li>
                    <li class="nav-prod-item">
                        <span class="nav-prod-link">{{ $producto->titulo }}</span>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <div class="img-cont">
                    <div class="zoom-btn" id="zoom-button">
                        <i class='bx bx-search'></i>
                    </div>
                    <div class="wm-zoom-container zoom1">
                        <div class="wm-zoom-box">
                            <img src="" class="wm-zoom-default-img small-img" id="img-zoom" data-hight-src="" data-loader-src="{{ asset('web/assets/img/loader.gif') }}" alt="">
                        </div>
                    </div>
                </div>

                <section class="container-grid-img">
                    <?php 
                    $images = explode(';',$producto->galeria_imagenes);
                    $descriptions = explode(';',$producto->descripcion_imagenes);
                    $count = 0
                    ?>
                    @foreach ($images as $img)
                        @if (strpos($img, '&') !== false)
                        <img src="/storage/files/{{ $img }}" alt="{{ $descriptions[$count] }}" class="img-gallery img-gallery-{{ $count+1 }} @if ($count == 0) active @endif">
                        <?php $count+= 1 ?>
                        @endif
                    @endforeach
                </section>
            </div>
            <div class="col-md-6">
                <div class="single-product-content">
                    <h3>{{ $producto->titulo }}</h3>
                    <div class="container-star">
                        <div class="star-widget disabled star-cont" data-stars="{{ $producto->puntuacion }}">
                            <input type="radio" name="rate" id="rate-5">
                            <label for="rate-5" id="label-rate-1-5-p" class="fas fa-star"></label>
                            <input type="radio" name="rate" id="rate-4">
                            <label for="rate-4" id="label-rate-1-4-p" class="fas fa-star"></label>
                            <input type="radio" name="rate" id="rate-3">
                            <label for="rate-3" id="label-rate-1-3-p" class="fas fa-star"></label>
                            <input type="radio" name="rate" id="rate-2">
                            <label for="rate-2" id="label-rate-1-2-p" class="fas fa-star"></label>
                            <input type="radio" name="rate" id="rate-1">
                            <label for="rate-1" id="label-rate-1-1-p" class="fas fa-star"></label>
                        </div>
                    </div>
                    <span class="product-price">
                        <span class="price-amount">
                            <bdi>
                                <span class="price-symbol">$</span>{{ $producto->precio }}
                            </bdi>
                        </span>
                    </span>
                    {!! $producto->descripcion !!}
                    <p>
                        <script type="text/javascript">
                            function getUrl() {
                                return "{{ $producto->demo }}";
                            }
                        </script>
                    </p>
                    <div class="single-product-form">
                        <form class="cart" action="#" method="post" enctype="multipart/form-data">
                            <div class="quantity">
                                <label class="screen-reader-text" for="quantity">{{ $producto->titulo }}</label>
                                <input type="hidden" readonly="readonly" class="input-text qty text" name="quantity" value="1" title="Cantidad" size="4" min="1" max="1">
                            </div>
                        
                            <button type="submit" name="add-to-cart" value="3249" class="single_add_to_cart_button button alt wp-element-button">Añadir al carrito</button>
                        
                            <div class="wp-block-button is-style-secondary">
                                <a class="wp-block-button__link" href="javascript:document.location.href=getUrl();" rel="noreferrer noopener">Descargar Demo</a>
                            </div>
                            <a class="MyCustomButton" href="#" target="_blank" rel="noreferrer noopener">Ayuda</a>
                        </form>
                        <div id="paypal-button-container"></div>
                        <?php 
                            $cates = explode(',',$producto->categorias);
                        ?>
                        <p><strong>Categories: </strong>
                            @foreach ($cates as $cat)
                            <a href="#">{{ $cat }}</a>@if ($loop->last == false), @endif
                            @endforeach 
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end single product -->

<!-- Valoracion producto -->
<div class="tabs-cont mt-5 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-descripcion-tab" data-bs-toggle="tab" data-bs-target="#nav-descripcion" type="button" role="tab" aria-controls="nav-descripcion" aria-selected="true">Descripción</button>
                        <button class="nav-link " id="nav-valoracion-tab" data-bs-toggle="tab" data-bs-target="#nav-valoracion" type="button" role="tab" aria-controls="nav-valoracion" aria-selected="false">Valoraciones ({{ $valoracionT->total }})</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade fadeInRightBig fadeOutLeft show active" id="nav-descripcion" role="tabpanel" aria-labelledby="nav-descripcion-tab">
                        {!! $producto->contenido !!}
                    </div>
                    <div class="tab-pane fade fadeInLeftBig fadeOutRight" id="nav-valoracion" role="tabpanel" aria-labelledby="nav-valoracion-tab">
                        <div class="valo-cont">
                            <div class="comments-list-wrap">
                                <h3 class="comment-count-title">{{ $valoracionT->total }} Valoraciónes</h3>
                                <div class="comment-list">
                                    @php
                                        $value = 1
                                    @endphp
                                    @foreach ($valoraciones as $val)
                                    <div class="single-comment-body">
                                        <div class="comment-user-avater">
                                            <img src="{{ asset('web/assets/img/avaters/avatar1.png') }}" alt="">
                                            <lord-icon src="https://cdn.lordicon.com/hbvyhtse.json" trigger="loop" delay="3000" colors="primary:#121331" state="intro" style="width:60px;height:60px">
                                            </lord-icon>
                                        </div>
                                        <div class="comment-text-body">
                                            <div class="title-valo">
                                                <h4>{{ $val->name }} - <span class="comment-date">{{ \Carbon\Carbon::parse($val->fecha_publicacion)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</span></h4>
                                                <div class="container-star">
                                                    <div class="star-widget disabled star-cont" data-stars="{{ $val->puntuacion }}">
                                                        <input type="radio" name="rate" id="rate-5">
                                                        <label for="rate-5" id="label-rate-{{ $value }}-5-c" class="fas fa-star"></label>
                                                        <input type="radio" name="rate" id="rate-4">
                                                        <label for="rate-4" id="label-rate-{{ $value }}-4-c" class="fas fa-star"></label>
                                                        <input type="radio" name="rate" id="rate-3">
                                                        <label for="rate-3" id="label-rate-{{ $value }}-3-c" class="fas fa-star"></label>
                                                        <input type="radio" name="rate" id="rate-2">
                                                        <label for="rate-2" id="label-rate-{{ $value }}-2-c" class="fas fa-star"></label>
                                                        <input type="radio" name="rate" id="rate-1">
                                                        <label for="rate-1" id="label-rate-{{ $value }}-1-c" class="fas fa-star"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <p>{{ $val->comentario }}</p>
                                        </div>
                                    </div>
                                    @php
                                        $value++;
                                    @endphp
                                    @endforeach
                                </div>
                            </div>
                            <div class="comment-template">
                                <h4>Añadir una valoración</h4>
                                @guest
                                <div class="login-cont">
                                    <p>Para publicar una valoración primero debes iniciar sesión en tu cuenta CodeTech.</p>
                                    <a href="{{ route('login') }}" class="boxed-btn">Iniciar Sesión</a>
                                </div>
                                @else
                                <form method="POST" action="{{ route('addValoracion') }}">
                                    @csrf
                                    <p>
                                        <label class="label-text" for="puntuacion">Tu puntuación <span class="required-value-mark"></span></label>
                                        <input type="hidden" name="puntuacion" id="puntuacion">
                                    </p>
                                    <div class="container-star">
                                        <div class="star-widget active-click star-cont" data-stars="">
                                            <input type="radio" name="rate" id="rate-5">
                                            <label for="rate-5" id="label-rate-5" class="fas fa-star"></label>
                                            <input type="radio" name="rate" id="rate-4">
                                            <label for="rate-4" id="label-rate-4" class="fas fa-star"></label>
                                            <input type="radio" name="rate" id="rate-3">
                                            <label for="rate-3" id="label-rate-3" class="fas fa-star"></label>
                                            <input type="radio" name="rate" id="rate-2">
                                            <label for="rate-2" id="label-rate-2" class="fas fa-star"></label>
                                            <input type="radio" name="rate" id="rate-1">
                                            <label for="rate-1" id="label-rate-1" class="fas fa-star"></label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="usuario" id="usuario" value="{{ Auth::user()->id }}">
                                    <input type="hidden" name="producto" id="producto" value="{{ $producto->id }}">
                                    <input type="hidden" name="fecha_publicacion" id="fecha_publicacion" value="{{ \Carbon\Carbon::now()->locale('es')->format('d/m/Y') }}">
                                    <p>
                                        <label class="label-text" for="comentario">Valoración <span class="required-value-mark"></span></label>
                                        <textarea name="comentario" id="comentario" cols="45" rows="8"></textarea>
                                    </p>
                                    <p><input type="submit" value="Enviar"></p>
                                </form>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- more products -->
<div class="more-products mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="section-title">	
                    <h3>Productos <span class="orange-text">Relacionados</span></h3>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($relacionados as $rel)
            <div class="col-lg-3 col-md-6">
                <div class="single-product-item">
                    <div class="product-image">
                        <a href="single-product.html"><img src="/storage/files/{{ $rel->imagen }}" alt="{{ $rel->titulo }}"></a>
                    </div>
                    <h2>{{ $rel->titulo }}</h2>
                    <div class="container-star">
                        <div class="star-widget disabled star-cont" data-stars="2">
                            <input type="radio" name="rate" id="rate-5">
                            <label for="rate-5" id="label-rate-1-5" class="fas fa-star"></label>
                            <input type="radio" name="rate" id="rate-4">
                            <label for="rate-4" id="label-rate-1-4" class="fas fa-star"></label>
                            <input type="radio" name="rate" id="rate-3">
                            <label for="rate-3" id="label-rate-1-3" class="fas fa-star"></label>
                            <input type="radio" name="rate" id="rate-2">
                            <label for="rate-2" id="label-rate-1-2" class="fas fa-star"></label>
                            <input type="radio" name="rate" id="rate-1">
                            <label for="rate-1" id="label-rate-1-1" class="fas fa-star"></label>
                        </div>
                    </div>
                    <span class="product-price">
                        <span class="price-amount">
                            <bdi>
                                <span class="price-symbol">$</span>{{ $rel->precio }}
                            </bdi>
                        </span>
                    </span>
                    <button class="cart-btn">
                        <span>Añadir al carrito</span>
                        <div class="cart">
                            <svg viewBox="0 0 36 26">
                                <polyline points="1 2.5 6 2.5 10 18.5 25.5 18.5 28.5 7.5 7.5 7.5"></polyline>
                                <polyline points="15 13.5 17 15.5 22 10.5"></polyline>
                            </svg>
                        </div>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- end more products -->
@stop

@section('photo')
<!-- photoswipe -->
<div class="pswp pswp--supports-fs pswp--open pswp--notouch pswp--css_animation pswp--svg pswp--animated-in pswp--zoom-allowed pswp--not_visible pswp--has_mouse" tabindex="-1" role="dialog" aria-hidden="false" style="position: fixed; opacity: 1;">
    <div class="pswp__bg" style="opacity: 1;"></div>
    <div class="pswp__scroll-wrap">
        <div class="pswp__container" style="transform: translate3d(0px, 0px, 0px);">
            <div class="pswp__item" style="transform: translate3d(0px, 0px, 0px);">
                <div class="pswp__zoom-wrap">
                    <div class="pswp__img pswp__img--placeholder pswp__img--placeholder--blank" style="width: 860px;height: 561px;display: none;"></div>
                    <img class="pswp__img" src="" alt="" style="display: block;">
                </div>
            </div>
        </div>
        <div class="pswp__ui pswp__ui--fit pswp__ui--over-close">
            <div class="pswp__top-bar">
                <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close" aria-label="Cerrar (Esc)"></button>
                <button class="pswp__button pswp__button--share pswp__element--disabled" aria-label="Compartir"></button>
                <button class="pswp__button pswp__button--fs" aria-label="Cambiar a pantalla completa"></button>
                <button class="pswp__button pswp__button--zoom" aria-label="Ampliar/Reducir"></button>
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap pswp__element--disabled">
                <div class="pswp__share-tooltip"></div>
            </div>
            <button class="pswp__button pswp__button--arrow--left" aria-label="Anterior (flecha izquierda)"></button>
            <button class="pswp__button pswp__button--arrow--right" aria-label="Siguiente (flecha derecha)"></button>
            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>
<!-- end photoswipe -->
@stop

@section('scripts')
<!-- photoswipe -->
<script src="{{ asset('web/assets/js/jquery.wm-zoom-1.0.js') }}"></script>
<script src="{{ asset('web/assets/js/photoswipe.js') }}"></script>
<!-- lordicon -->
<script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
<!-- paypal -->
<script src="https://www.paypal.com/sdk/js?client-id=AcrXzHCxeiiTB60td8-zvYf2nfwOKBMYG_uYiH7t-k4ILvTLAH-aXMq4rTKisAP-BRsRJZyJNG9smklm&components=buttons,funding-eligibility&commit=true&intent=capture&enable-funding=venmo,paylater&vault=false&currency=USD&integration-date=2023-04-13"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const stardivprinc = document.querySelectorAll('.single-product-content .star-cont');
    var stars;
    for (let i = 0; i < stardivprinc.length; i++) {
        if (stardivprinc[i].classList.contains('disabled')) {
            stars = stardivprinc[i].getAttribute('data-stars');
            for (let j = 0; j < stars; j++) {
                const lbl = document.getElementById('label-rate-' + (i + 1) + '-' + (j + 1) + '-p');
                if (stars == 5) {
                    lbl.style.color = '#fe7';
                    lbl.style.textShadow = '0 0 12px #952';
                    lbl.style.fontWeight = '900';
                }
                else {
                    lbl.style.color = '#fd4'
                    lbl.style.fontWeight = '900';
                }
            }
        }
    }
</script>

<script>
    const stardiv = document.querySelectorAll('.single-product-item .star-cont');
    var stars;
    for (let i = 0; i < stardiv.length; i++) {
        if (stardiv[i].classList.contains('disabled')) {
            stars = stardiv[i].getAttribute('data-stars');
            for (let j = 0; j < stars; j++) {
                const lbl = document.getElementById('label-rate-' + (i + 1) + '-' + (j + 1));
                if (stars == 5) {
                    lbl.style.color = '#fe7';
                    lbl.style.textShadow = '0 0 12px #952';
                    lbl.style.fontWeight = '900';
                }
                else {
                    lbl.style.color = '#fd4'
                    lbl.style.fontWeight = '900';
                }
            }
        }
    }
</script>

<script>
    const starcomments = document.querySelectorAll('.comment-text-body .star-cont');
    var stars;
    for (let i = 0; i < starcomments.length; i++) {
        if (starcomments[i].classList.contains('disabled')) {
            stars = starcomments[i].getAttribute('data-stars');
            for (let j = 0; j < stars; j++) {
                const lbl = document.getElementById('label-rate-' + (i + 1) + '-' + (j + 1)+'-c');
                if (stars == 5) {
                    lbl.style.color = '#fe7';
                    lbl.style.textShadow = '0 0 12px #952';
                    lbl.style.fontWeight = '900';
                }
                else {
                    lbl.style.color = '#fd4'
                    lbl.style.fontWeight = '900';
                }
            }
        }
    }
</script>

<script>
    const staractive = document.querySelectorAll('.comment-template .star-cont.active-click label');
    for (let i = 0; i < staractive.length; i++) {
        staractive[i].addEventListener('click',(e)=>{
            const id_val = e.target.id;
            const val = id_val.split('-')[2];
            color(val);
            const cont_act = document.getElementById('puntuacion');
            cont_act.value = val;
        })
    }

    function color(stars) {
        for (let i = 0; i < 5; i++) {
            const lbl_br = document.getElementById('label-rate-' + (i + 1));
            lbl_br.style.color = '#444'
            lbl_br.style.fontWeight = '400';
            lbl_br.style.textShadow = '0 0 0 #952';	
        }
        for (let i = 0; i < stars; i++) {
            if (stars == 5) {
                const lbl = document.getElementById('label-rate-' + (i + 1));
                lbl.style.color = '#fe7';
                lbl.style.textShadow = '0 0 12px #952';
                lbl.style.fontWeight = '900';
            }
            else {
                const lbl = document.getElementById('label-rate-' + (i + 1));
                lbl.style.color = '#fd4'
                lbl.style.fontWeight = '900';
            }
        }			
    }
</script>

<script>
    document.querySelectorAll('.cart-btn').forEach(button =>
        button.addEventListener('click', e => {
            if (!button.classList.contains('loading')) {
                button.classList.add('loading');
                setTimeout(() => button.classList.remove('loading'), 3700);
            }
            e.preventDefault();
        }));
</script>
<?php 
$reference_id = base64_encode($producto->id.'|paypal|'.$producto->precio);
?>
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var button = paypal.Buttons({
        fundingSource: paypal.FUNDING.PAYPAL,
        style: {
            layout: 'vertical',
            color: 'gold',
            shape: 'rect',
            label: 'pay'
        },
        createOrder: (data, actions) => {
            return actions.order.create({
                purchase_units: [
                    {
                        "reference_id": "{{ $reference_id }}",
                        "description": "Productos CodeTech 01",
                        "amount": {
                            "currency_code": "USD",
                            "value": "{{ $producto->precio }}",
                            "breakdown": {
                                "item_total": {
                                    "currency_code": "USD",
                                    "value": "{{ $producto->precio }}",
                                },
                            }
                        },
                        "items": [
                            {
                                "name": "{{ $producto->titulo }}",
                                "quantity": "1",
                                "unit_amount": {
                                    "currency_code": "USD",
                                    "value": "{{ $producto->precio }}"
                                },
                            },
                        ]
                    }
                ]
            });
        },
        onCancel: (data) => {
            alert('Pago Cancelado');
        },
        onError(err) {
            alert('Ocurrio un error al intentar reaizar el pago. Intentelo nuevamente\n' + err);
        },
        onApprove: (data, actions) => {
            return actions.order.capture().then(function (orderData) {
                console.log(JSON.stringify(orderData));
                const url = '/paypal-transact';
                const options = {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify(orderData),
                };
                fetch(url, options)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Hubo un problema al enviar la solicitud.');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: "btn btn-primary-sa"
                            },
                            buttonsStyling: false
                        });
                        swalWithBootstrapButtons.fire({
                            title: "Compra exitosa!",
                            icon: "info",
                            html: 'Despues de confirmar tu pedido podrás consultar los detalles de tu compra <a href="#" target="_blank" rel="noopener noreferrer">aqui</a>.',
                            confirmButtonText: "Continuar",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = `/checkout-approve/${data.compra}`;
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error('Error al enviar la solicitud:', error);
                });
            });
        }
    });
    if (button.isEligible) {
        button.render('#paypal-button-container');
    }
</script>
@stop