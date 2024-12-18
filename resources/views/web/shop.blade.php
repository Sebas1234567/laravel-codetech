@extends('layout.web')

@section('title')Tienda @stop

@section('styles')
@stop

@section('content')
<!-- breadcrumb-section -->
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text text-center">
                    <h1>Tienda</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- products -->
<div class="product-section mt-2 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form class="woocommerce-ordering" method="get">
                    <select name="orderby" class="orderby" aria-label="Pedido de la tienda" onchange="this.form.submit()">
                        <option id="popularity" value="popularity">Ordenar por popularidad</option>
                        <option id="rating" value="rating">Ordenar por puntuación media</option>
                        <option id="date" value="date">Ordenar por los últimos</option>
                        <option id="price" value="price">Ordenar por precio: bajo a alto</option>
                        <option id="price-desc" value="price-desc">Ordenar por precio: alto a bajo</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-light" role="alert">
                    <div class="img-alert">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <p>
                        Si tiene <strong>algún inconveniente</strong> con su compra, escríbame al <strong>correo:</strong> <a href="mailto:code.tech.evolution@gmail.com?subject=Compra%20de%20Proyecto" target="_blank" rel="noopener">code.tech.evolution@gmail.com</a>, <strong>asunto:</strong> Compra de Proyecto. <br> Tambien puede ver los tutoriales de como comprar usando una cuenta <a href="#" target="_blank" rel="noopener">PayPal</a> o una <a href="#" target="_blank" rel="noopener">tarjeta bancaria</a>.
                    </p>
                </div>
            </div>
        </div>

        <div class="row product-lists">
            @php
                $count=1;
            @endphp
            @foreach ($productos as $prod)
            <div class="col-lg-4 col-md-6">
                <div class="single-product-item">
                    <div class="product-image">
                        <a href="{{ route('shop.detail',['sku'=>$prod->sku]) }}">
                            <img src="/storage/files/{{ $prod->imagen }}" alt="{{ $prod->titulo }}" />
                        </a>
                    </div>
                    <h2>{{ $prod->titulo }}</h2>
                    <div class="container-star">
                        <div class="star-widget disabled star-cont" data-stars="@if ($prod->puntuacion){{ $prod->puntuacion }} @else 0 @endif">
                            <input type="radio" name="rate" id="rate-5">
                            <label for="rate-5" id="label-rate-{{ $count }}-5" class="fas fa-star"></label>
                            <input type="radio" name="rate" id="rate-4">
                            <label for="rate-4" id="label-rate-{{ $count }}-4" class="fas fa-star"></label>
                            <input type="radio" name="rate" id="rate-3">
                            <label for="rate-3" id="label-rate-{{ $count }}-3" class="fas fa-star"></label>
                            <input type="radio" name="rate" id="rate-2">
                            <label for="rate-2" id="label-rate-{{ $count }}-2" class="fas fa-star"></label>
                            <input type="radio" name="rate" id="rate-1">
                            <label for="rate-1" id="label-rate-{{ $count }}-1" class="fas fa-star"></label>
                        </div>
                    </div>
                    @php
                        $count++;
                    @endphp
                    <span class="product-price">
                        <span class="price-amount">
                            <bdi>
                                <span class="price-symbol">$</span>{{ $prod->precio }}
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

        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="pagination-wrap">
                    <ul>
                        <li><a href="{{ $productos->previousPageUrl() }}" class="@if ($productos->onFirstPage())disabled @endif">Prev</a></li>
                        @for ($i=1; $i < $productos->lastPage()+1; $i++)
                        <li><a href="{{ $productos->url($i) }}" class="@if ($i == $productos->currentPage())active @endif">{{ $i }}</a></li>
                        @endfor
                        <li><a href="{{ $productos->nextPageUrl() }}" class="@if ($productos->lastPage() == $productos->currentPage())disabled @endif">Next</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end products -->
@stop

@section('scripts')
<!-- filter -->
<script src="{{ asset('web/assets/js/filter.js') }}"></script>

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

<script>
    const urlSearchParams = new URLSearchParams(window.location.search);
    const order = urlSearchParams.get("orderby");
    if (order === null) {
        const option = document.getElementById('date');
        option.setAttribute("selected", "selected");
    }
    else {
        const option = document.getElementById(order);
        option.setAttribute("selected", "selected");
    }
</script>

<script>
    const stardiv = document.querySelectorAll('.star-cont');
    var stars;
    for (let i = 0; i < stardiv.length; i++) {
        if (stardiv[i].classList.contains('disabled')) {
            stars = stardiv[i].getAttribute('data-stars');
            for (let j = 0; j < stars; j++) {
                const lbl = document.getElementById('label-rate-' + (i+1) + '-' + (j+1));
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
@stop