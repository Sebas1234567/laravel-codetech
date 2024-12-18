@extends('layout.web')

@section('title')Resultado de la busqueda de «{{ $search }}» @stop

@section('styles')
@stop

@section('content')
<!-- breadcrumb-section -->
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h1>Resultados de la búsqueda de: {{ $search }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- latest news -->
<div class="latest-news mt-5 mb-150 news-page">
    <div class="container">
        <div class="row">
            @foreach ($entradas as $ent)
                @if ($loop->index % 2 ==0)
                <div class="single-latest-news col-lg-12">
                    <div class="row">
                        <div class="latest-news-bg col-lg-5">
                            <img src="/storage/files/{{ $ent->imagen }}" alt="{{ $ent->titulo }}" id="bg-poster1">
                            <span class="date-article left-date">
                                <i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($ent->fecha_publicacion)->locale('es')->formatLocalized('%B %d %Y') }}
                            </span>
                        </div>
                        <div class="news-text-box col-lg-7">
                            <h3><a href="single-news.html">{{ $ent->titulo }}</a></h3>
                            <p class="blog-meta">
                                <span class="author"><i class="fas fa-user"></i> por <a href="#">{{ $ent->autor }}</a></span>
                            </p>
                            <p class="excerpt">{{ $ent->descripcion }}</p>
                            <a href="single-news.html" class="read-more-btn btn-news">
                                <span class="circle-btn" aria-hidden="true">
                                    <span class="arrow_icon"></span>
                                </span>
                                <span class="button_text">Read More</span>
                            </a>
                        </div>
                    </div>
                </div>
                @else
                <div class="single-latest-news col-lg-12">
                    <div class="row">
                        <div class="news-text-box col-lg-7">
                            <h3><a href="single-news.html">{{ $ent->titulo }}</a></h3>
                            <p class="blog-meta">
                                <span class="author"><i class="fas fa-user"></i> por <a href="#">{{ $ent->autor }}</a></span>
                            </p>
                            <p class="excerpt">{{ $ent->descripcion }}</p>
                            <a href="single-news.html" class="read-more-btn btn-news">
                                <span class="circle-btn" aria-hidden="true">
                                    <span class="arrow_icon"></span>
                                </span>
                                <span class="button_text">Read More</span>
                            </a>
                        </div>
                        <div class="latest-news-bg col-lg-5 right-date">
                            <img src="/storage/files/{{ $ent->imagen }}" alt="" id="bg-poster1">
                            <span class="date-article right-date">
                                <i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($ent->fecha_publicacion)->locale('es')->formatLocalized('%B %d %Y') }}
                            </span>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>

        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="pagination-wrap">
                            <ul>
                                <li><a href="{{ $entradas->previousPageUrl() }}" class="@if ($entradas->onFirstPage())disabled @endif">Prev</a></li>
                                @for ($i=1; $i < $entradas->lastPage()+1; $i++)
                                <li><a href="{{ $entradas->url($i) }}" class="@if ($i == $entradas->currentPage())active @endif">{{ $i }}</a></li>
                                @endfor
                                <li><a href="{{ $entradas->nextPageUrl() }}" class="@if ($entradas->lastPage() == $entradas->currentPage())disabled @endif">Next</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end latest news -->
@stop

@section('scripts')
@stop