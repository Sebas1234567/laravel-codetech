@extends('layout.web')

@section('title')Cursos @stop

@section('styles')
@stop

@section('content')
<!-- breadcrumb-section -->
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text text-center">
                    <h1>Cursos</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- products -->
<div class="product-section mt-2 mb-5">
    <div class="container">
        <div class="row ">
            <div class="tabs-container col-lg-2 col-md-2 col-sm-2">
                <nav class="tabs">
                    <ul class="tabs-list">
                        <li><a href="" class="filter-link filter-active" data-id="*">All</a></li>
                        @foreach ($categorias as $cat)
                        <li><a href="#" class="filter-link" data-id="{{ $cat->nombre }}">{{ $cat->nombre }}</a></li>
                        @endforeach
                    </ul>
                </nav>
            </div>
            <div class="container col-lg-10 col-md-10 col-sm-10">
                <div class="row" id="course-container">
                    @foreach ($cursos as $cur)
                    <div class="card-course course-item col-lg-4 col-md-6 col-sm-12" data-groups="[&quot;*&quot;,&quot;{{ $cur->nombre }}&quot;]">
                        <div class="card-image">
                            <img src="/storage/files/{{ $cur->imagen }}" alt="{{ $cur->titulo }}" loading="lazy" style="max-width: 100%; height: auto;">
                            <span class="card-tag">{{ $cur->nombre }}</span>
                            <span class="card-price">@if ($cur->precio == '0.00') Gratis @else S/. {{ $cur->precio }}@endif</span>
                        </div>
                        <div class="card-content">
                            <h6>{{ $cur->titulo }}</h6>
                            <ul class="card-content-details">
                                <li class="card-content-detail list-course">
                                    <span class="card-detail-text" data-bs-toggle="tooltip" data-placement="bottom" title="{{ \Carbon\CarbonInterval::seconds($cur->duracion)->cascade()->forHumans() }} de duración.">
                                        <i class="fa-duotone fa-clock-rotate-left"></i>
                                        <!-- 11 horas 10 minutos de duración. -->
                                    </span>
                                </li>
                                <li class="card-content-detail list-course">
                                    <span class="card-detail-text" data-bs-toggle="tooltip" data-placement="bottom" title="{{ $cur->cantidad_clases }} clases en videos HD.">
                                        <i class="fa-duotone fa-circle-play"></i>
                                        <!-- 68 clases en videos HD. -->
                                    </span>
                                </li>
                                <li class="card-content-detail list-course">
                                    <span class="card-detail-text" data-bs-toggle="tooltip" data-placement="bottom" data-html="true" title="<b>Puedes ver el curso en línea y repetirlo cuantas veces lo requieras.</b>">
                                        <i class="fa-duotone fa-eye"></i>
                                        <!-- <b>Puedes ver el curso en línea y repetirlo cuantas veces lo requieras.</b> -->
                                    </span>
                                </li>
                                @if ($cur->certificado)
                                <li class="card-content-detail list-course">
                                    <span class="card-detail-text" data-bs-toggle="tooltip" data-placement="bottom" title="Certificado de finalización.">
                                        <i class="fa-duotone fa-trophy"></i>
                                        <!-- Certificado de finalización. -->
                                    </span>
                                </li>
                                @endif
                            </ul>
                            <div class="button-content">
                                <a href="#" class="button-course btn-detail">
                                    <span class="btn-text">Aprende más</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2"></div>
            <div class="col-lg-10 col-md-10 col-sm-10 text-center">
                <div class="pagination-wrap">
                    <ul>
                        <li><a href="#">Mostrar más</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end products -->
@stop

@section('scripts')
<!-- shuffle js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Shuffle/6.1.0/shuffle.min.js"></script>
<script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>

<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl,{html:true}))
</script>

<script>
    $(document).ready(function($){
        function showShuffleElements() {
            const Shuffle = window.Shuffle;
            const element = document.getElementById('course-container');
            if (element !== null) {
                imagesLoaded(element, function() {
                    const shuffleInstance = new Shuffle(element, {
                        itemSelector: '.course-item',
                        group: ["*", @foreach ($categorias as $cat) "{{ $cat->nombre }}", @endforeach]
                    });

                    const allClasses = document.getElementsByClassName('filter-link');
                    var getData = function(event) {
                        event.preventDefault();
                        let clickedElement = event.target;
                        let filterId = clickedElement.getAttribute('data-id');
                        shuffleInstance.filter(filterId);
                        for (var i = 0; i < allClasses.length; i++) {
                            console.log(allClasses[i].classList);
                            if( allClasses[i].classList.contains('filter-active')){
                                allClasses[i].classList.remove('filter-active');
                            }
                        }
                        clickedElement.classList.add('filter-active');
                    }
                    for (var i = 0; i < allClasses.length; i++) {
                        allClasses[i].addEventListener('click', getData, false);
                    }
                    const selectedClasses = document.getElementsByClassName('filter-link filter-active');
                    var defaultFilter = selectedClasses[0].getAttribute('data-id');
                    shuffleInstance.filter(defaultFilter);
                });
            }
        }
        showShuffleElements();
    });
</script>
@stop