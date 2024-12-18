@extends('layout.web')

@section('title'){{ $entrada->titulo }} @stop

@section('styles')
<!-- magnific popup -->
<link rel="stylesheet" href="{{ asset('web/assets/css/magnific-popup.css') }}">
<!-- enlighterjs -->
<link rel="stylesheet" href="{{ asset('web/assets/enlighterjs/css/enlighterjs.min.css') }}">
<!-- wpzoom-icon -->
<link rel="stylesheet" href="{{ asset('web/assets/css/wpzoom-socicon.css') }}">
<link rel="stylesheet" href="{{ asset('web/assets/css/wpzoom-social-icons-styles.css') }}">
@stop

@section('content')
<!-- single article section -->
<div class="pt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 br-post">
                <div class="single-article-section">
                    <div class="single-article-text">
                        <h1>{{ $entrada->titulo }}</h1>
                        <p class="blog-meta">
                            <span class="author"><i class="fas fa-user"></i> por <a href="#">{{ $entrada->autor }}</a></span>
                        </p>
                        <div class="single-artcile-bg" style="background-image: url('storage/files/{{ $entrada->imagen }}')">
                            <span class="date-article right-date">
                                <i class="fas fa-calendar"></i>  {{ \Carbon\Carbon::parse($entrada->fecha_publicacion)->locale('es')->formatLocalized('%B %d %Y') }}
                            </span>
                        </div>
                        <p>{{ $entrada->descripcion }}</p>
                        {!! $entrada->contenido !!}
                        <figure class="block-embed">
                            <div class="block-embed__wrapper">
                                <div class="iframe-embed">
                                    <iframe loading="lazy" title="CRUD with MVP pattern, C#, WinForms and SQL Server" width="1200" height="675" src="/ve/embed/{{ $entrada->idvideo }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                                </div>
                            </div>
                        </figure>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="sidebar-section">
                    <div class="search-section">
                        <h4>Busqueda de Entradas</h4>
                        <form method="get" action="{{ route('index') }}">
                            <input type="text" placeholder="Buscar..." name="s" id="s">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                    <div class="social-section zoom-social-icons-widget">
                        <h4>Sígueme</h4>
                        <ul class="zoom-social-icons-list zoom-social-icons-list--with-canvas zoom-social-icons-list--rounded zoom-social-icons-list--no-labels">
                            <li class="zoom-social_icons-list__item">
                                <a class="zoom-social_icons-list__link" href="#" target="_blank" title="Default Label">
                                    <span class="screen-reader-text">youtube</span>
                                    <span class="zoom-social_icons-list-span social-icon socicon socicon-youtube" data-hover-rule="background-color" data-hover-color="#e02a20" style="background-color: #322B6A; font-size: 18px; padding: 8px;" data-old-color="#322B6A"></span>
                                </a>
                            </li>
                            <li class="zoom-social_icons-list__item">
                                <a class="zoom-social_icons-list__link" href="#" target="_blank" title="Facebook">
                                    <span class="screen-reader-text">facebook</span>
                                    <span class="zoom-social_icons-list-span social-icon socicon socicon-facebook" data-hover-rule="background-color" data-hover-color="#1877F2" style="background-color : #322B6A; font-size: 18px; padding:8px"></span>
                                </a>
                            </li>
                            <li class="zoom-social_icons-list__item">
                                <a class="zoom-social_icons-list__link" href="#" target="_blank" title="Instagram">
                                    <span class="screen-reader-text">instagram</span>
                                    <span class="zoom-social_icons-list-span social-icon socicon socicon-instagram" data-hover-rule="background-color" data-hover-color="#e4405f" style="background-color : #322B6A; font-size: 18px; padding:8px"></span>
                                </a>
                            </li>
                            <li class="zoom-social_icons-list__item">
                                <a class="zoom-social_icons-list__link" href="#" target="_blank" title="Default Label">
                                    <span class="screen-reader-text">github</span>
                                    <span class="zoom-social_icons-list-span social-icon socicon socicon-github" data-hover-rule="background-color" data-hover-color="#221e1b" style="background-color : #322B6A; font-size: 18px; padding:8px"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="recent-posts">
                        <h4>Recent Posts</h4>
                        <ul>
                            @foreach ($ultimos as $ult)
                            <li><a href="{{ route('posts.detail',['slug'=>$ult->slug]) }}">{{ $ult->titulo }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="archive-posts">
                        <h4>Categorias</h4>
                        <ul>
                            @foreach ($categorias as $cate)
                            <li>
                                <a href="{{ route('posts',['categoria'=>$cate->nombre]) }}">{{ $cate->nombre }}</a>
                                <ul>
                                    @foreach ($cate->hijos as $cateH)
                                    @if ($cateH->estado)
                                    <li><a href="{{ route('posts',['categoria'=>$cateH->nombre]) }}">{{ $cateH->nombre }}</a></li>
                                    @endif
                                    @endforeach
                                </ul>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="tag-section">
                        <h4>Tags</h4>
                        <?php $tags = explode(',',$entrada->categorias); ?>
                        <ul>
                            @foreach ($tags as $tag)
                            <li><a class="tag-item" href="{{ route('posts',['categoria'=>$tag]) }}">{{ $tag }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end single article section -->
@stop

@section('scripts')
<!-- magnific popup -->
<script src="{{ asset('web/assets/js/jquery.magnific-popup.min.js') }}"></script>
<!-- enlighterjs -->
<script type="text/javascript" src="{{ asset('web/assets/enlighterjs/js/enlighterjs.min.js') }}"></script>
<script type="text/javascript">
    var o = { 
        "selectors": { "block": "pre", "inline": "code" }, 
        "options": { 
            "indent": 2, 
            "ampersandCleanup": true, 
            "linehover": true, 
            "rawcodeDbclick": false, 
            "textOverflow": "scroll", 
            "linenumbers": false, 
            "theme": "dracula", 
            "language": "generic", 
            "retainCssClasses": false, 
            "collapse": false, 
            "toolbarOuter": "", 
            "toolbarTop": "{BTN_RAW}{BTN_COPY}{BTN_WINDOW}{BTN_WEBSITE}", 
            "toolbarBottom": "" 
        } 
    }; 
    EnlighterJS.init(o.selectors.block, o.selectors.inline, o.options);
</script>
<!-- wpzoom-icon -->
<script src="{{ asset('web/assets/js/social-icons-widget-frontend.js') }}"></script>
@stop