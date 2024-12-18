@extends('layout.web')

@section('titulo')CodeTech - Transformando el mundo @endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('web/assets/libs/jquery-raty-js/lib/jquery.raty.css') }}">
@endsection

@section('content')
<section class="hero-section position-relative overflow-hidden mb-0 mb-lg-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-xl-6">
        <div class="hero-content my-5 my-xl-0">
          <h6 class="d-flex align-items-center gap-2 fs-4 fw-semibold mb-3" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
            <i class="ti ti-brand-stackshare text-primary fs-6"></i>Haz crecer tu proyecto digital con
          </h6>
          <h1 class="fw-bolder mb-7 fs-13" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
            Nuestra extensa colección
            <span class="text-primary"> de recursos tecnológicos</span>
            especializados
          </h1>
          <p class="fs-5 mb-5 text-dark fw-normal" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000">
            CodeTech ofrece recursos para aprender y perfeccionar habilidades de programación, dirigidos a todos los niveles de experiencia.
          </p>
          <div class="d-sm-flex align-items-center gap-3" data-aos="fade-up" data-aos-delay="800" data-aos-duration="1000">
            <a class="btn btn-primary px-5 py-6 btn-hover-shadow d-block mb-3 mb-sm-0" href="">Github</a>
            <a class="btn btn-outline-primary d-block scroll-link px-7 py-6" href="">Youtube</a>
          </div>
        </div>
      </div>
      <div class="col-xl-6 d-none d-xl-block">
        <div class="hero-img-slide position-relative bg-primary-subtle rounded">
          <div class="d-flex flex-row">
            <div class="bg-img"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="features-section py-5">
  <div class="container">
    <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4" data-aos="fade-up" data-aos-delay="800" data-aos-duration="1000">
        <div class="text-center mb-5">
          <i class="d-block ti ti-devices-code text-primary fs-10"></i>
          <h5 class="fs-5 fw-semibold mt-8">CODIGO PRÁCTICO</h5>
          <p class="mb-0 text-dark">
            Acceso a código práctico y real de diferentes lenguajes de programación, lo que permite experimentar y aprender de los errores más comunes en la programación.
          </p>
        </div>
      </div>
      <div class="col-sm-6 col-md-4 col-lg-4" data-aos="fade-up" data-aos-delay="800" data-aos-duration="1000">
        <div class="text-center mb-5">
          <i class="d-block ti ti-diamond text-primary fs-10"></i>
          <h5 class="fs-5 fw-semibold mt-8">CLARO Y ENFOCADO</h5>
          <p class="mb-0 text-dark">
            Ofrecen articulos y videotutoriales con ejercicios y proyectos completos de manera clara y concisa, con un enfoque estructurado y ordenado, lo que hace que el aprendizaje sea fácil de seguir
          </p>
        </div>
      </div>
      <div class="col-sm-6 col-md-4 col-lg-4" data-aos="fade-up" data-aos-delay="800" data-aos-duration="1000">
        <div class="text-center mb-5">
          <i class="d-block ti ti-bolt text-primary fs-10"></i>
          <h5 class="fs-5 fw-semibold mt-8">ACCESO GRATUITO</h5>
          <p class="mb-0 text-dark">
            Acceso gratuito a todo el contenido, incluyendo cursos en línea y recursos de programación para que puedan aprender y experimentar con diferentes lenguajes de programación.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="product-section py-5">
  <div class="container pt-md-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <h2 class="fs-9 text-center mb-4 mb-lg-5 fw-bolder" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">Nuestros Productos</h2>
      </div>
    </div>
    <div class="product-list" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
      <div class="row">
        @foreach ($productos as $prod)
        <div class="col-lg-3 col-md-6">
          <div class="card overflow-hidden hover-img">
            <div class="position-relative">
              <a href="/product/{{ $prod->sku }}">
                <img src="/storage/files/{{ $prod->imagen }}" class="card-img-top" alt="modernize-img">
              </a>
              <a href="javascript:void(0)" class="btn btn-primary rounded-circle p-2 d-flex align-items-center justify-content-center position-absolute bottom-0 end-0 me-3 mb-n3 fs-6" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Añadir al carrito">
                <i class="ti ti-basket"></i>
              </a>
            </div>
            <div class="card-body p-4">
              <h4 class="card-title">{{ $prod->titulo }}</h4>
              <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                  <h5 class="fs-4 mb-0">${{ $prod->precio }}</h5>
                  {{-- <p class="mb-0 text-decoration-line-through">$375</p> --}}
                </div>
                <div id="rating-{{ $prod->id }}" class="d-flex align-items-center"></div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    <div class="pt-md-5">
      <div class="row justify-content-center">
        <div class="col-lg-12 d-flex justify-content-center">
          <a href="{{ route('productos') }}" class="btn btn-primary btn-hover-shadow fs-4" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000">Ver más</a>
        </div>
      </div>
    </div>
  </div>
</section>
@if($promocion->isNotEmpty())
<section class="promotion-section py-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 d-flex align-items-center">
        <img src="/storage/files/{{ $promocion->imagen }}" alt="modernize-img" class="rounded w-100">
      </div>
      <div class="col-lg-6 col-md-6 d-flex flex-column justify-content-center">
        <h3 class="fs-9 fw-bolder" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">{{ $promocion->titulo }}</h3>
        <div class="fs-4 mb-4" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000">{{ $promocion->descripcion }}</div>
        <!--Countdown Timer-->
        <div class="time-counter mb-4" data-aos="fade-up" data-aos-delay="800" data-aos-duration="1000">
          <div class="time-countdown clearfix" data-countdown="{{ $promocion->fecha_fin }}">
            <div class="counter-column">
              <div class="inner">
                <span class="count">00</span>Days
              </div>
            </div> 
            <div class="counter-column">
              <div class="inner">
                <span class="count">00</span>Hours
              </div>
            </div>  
            <div class="counter-column">
              <div class="inner">
                <span class="count">00</span>Mins
              </div>
            </div>  
            <div class="counter-column">
              <div class="inner">
                <span class="count">00</span>Secs
              </div>
            </div>
          </div>
        </div>
        <a href="#" class="btn btn-outline-primary-2 fs-4 p-2 w-30" data-aos="fade-up" data-aos-delay="1000" data-aos-duration="1000"><i class="ti ti-shopping-cart fs-5"></i> Add to Cart</a>
      </div>
    </div>
  </div>
</section>
@endif
<section class="courses-section @if (!$promocion->isNotEmpty())promotion-section @endif py-5">
  <div class="container pt-md-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <h2 class="fs-9 text-center mb-4 mb-lg-5 fw-bolder" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">Nuestros Cursos</h2>
      </div>
    </div>
  </div>
  <div class="container" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
    <div class="row">
      @foreach ($cursos as $cur)
      <div class="col-lg-4 col-md-6">
        <div class="card overflow-hidden hover-img">
          <div class="row">
            <a href="javascript:void(0)">
              <img src="/storage/files/{{ $cur->imagen }}" class="w-100 h-100 rounded-0" alt="modernize-img">
            </a>
            <div class="card-body px-5 py-4">
              <a href="" class="link-primary-2 text-dark fs-6 fw-bold">{{ $cur->titulo }}</a>
              <ul class="d-flex align-items-center gap-1 mb-0 pb-2">
                <li>
                  <span class="fs-3 fw-bold">3.8</span>
                </li>
                <div id="rating-c-{{ $cur->id }}" class="d-flex align-items-center"></div>
              </ul>
              <div class="d-flex flex-column align-items-center">
                <p>{{ $cur->descripcion }}</p>
              </div>
              <ul class="d-flex align-items-center mb-0 list-unstyled pb-2">
                <li>
                  <span class="text-dark mr-3">
                    <i class="ti ti-users fs-5 mx-1"></i>
                    4131
                  </span>
                </li>
                <li>
                  <span class="text-dark">
                    <i class="ti ti-thumb-up fs-5 mr-1"></i>
                    90% (92)
                  </spa>
                </li>
              </ul>
              <ul class="d-flex align-items-center mb-0 list-unstyled">
                <li>
                  <span class="text-dark d-flex align-items-center">
                    Curso online:
                    @php
                      $interval = \Carbon\CarbonInterval::seconds($cur->duracion)->cascade();
                      $hours = $interval->hours;
                      $minutes = $interval->minutes;
                      $seconds = $interval->seconds;
                      if ($hours > 0) {
                        $formattedDuration = sprintf("%02dh: %02dm", $hours, $minutes);
                      } else {
                        $formattedDuration = sprintf("%02dm: %02ds", $minutes, $seconds);
                      }
                    @endphp
                    <i class="ti ti-clock fs-5 mx-1"></i>
                    {{ $formattedDuration }}
                  </span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  <div class="container pt-md-5" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000">
    <div class="row justify-content-center">
      <div class="col-lg-12 d-flex justify-content-center">
        <a href="{{ route('cursos') }}" class="btn btn-primary btn-hover-shadow fs-4">Ver más</a>
      </div>
    </div>
  </div>
</section>
<section class="review-section py-5">
  <div class="container pt-md-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <h2 class="fs-9 text-center mb-4 mb-lg-5 fw-bolder" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
          Experiencias de nuestros usuarios
        </h2>
      </div>
    </div>
    <div class="review-slider" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
      <div class="owl-carousel owl-theme">
        <div class="item">
          <div class="card">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between mb-4">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('web/assets/images/profile/user-1.jpg') }}" alt="modernize-img" class="w-auto me-3 rounded-circle" width="40" height="40" />
                  <div>
                    <h6 class="fs-4 mb-1 fw-semibold">Jenny Wilson</h6>
                    <p class="mb-0 text-dark">Features avaibility</p>
                  </div>
                </div>
                <div>
                  <ul class="list-unstyled d-flex align-items-center justify-content-end gap-1 mb-0">
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <p class="fs-4 mb-0 text-dark">
                The dashboard template from adminmart has helped me
                provide a clean and sleek look to my dashboard and made
                it look exactly the way I wanted it to, mainly without
                having.
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between mb-4">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('web/assets/images/profile/user-2.jpg') }}" alt="modernize-img" class="w-auto me-3 rounded-circle" width="40" height="40" />
                  <div>
                    <h6 class="fs-4 mb-1 fw-semibold">Minshan Cui</h6>
                    <p class="mb-0 text-dark">Features avaibility</p>
                  </div>
                </div>
                <div>
                  <ul class="list-unstyled d-flex align-items-center justify-content-end gap-1 mb-0">
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <p class="fs-4 text-dark mb-0">
                The quality of design is excellent, customizability and
                flexibility much better than the other products
                available in the market. I strongly recommend the
                AdminMart to other buyers.
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between mb-4">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('web/assets/images/profile/user-3.jpg') }}" alt="modernize-img" class="w-auto me-3 rounded-circle" width="40" height="40" />
                  <div>
                    <h6 class="fs-4 mb-1 fw-semibold">
                      Eminson Mendoza
                    </h6>
                    <p class="mb-0 fw-normal">Features avaibility</p>
                  </div>
                </div>
                <div>
                  <ul class="list-unstyled d-flex align-items-center justify-content-end gap-1 mb-0">
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <p class="fs-4 text-dark mb-0">
                This template is great, UI-rich and up-to-date. Although
                it is pretty much complete, I suggest to improve a bit
                of documentation. Thanks & Highly recomended!
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between mb-4">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('web/assets/images/profile/user-1.jpg') }}" alt="modernize-img" class="w-auto me-3 rounded-circle" width="40" height="40" />
                  <div>
                    <h6 class="fs-4 mb-1 fw-semibold">Jenny Wilson</h6>
                    <p class="mb-0 text-dark">Features avaibility</p>
                  </div>
                </div>
                <div>
                  <ul class="list-unstyled d-flex align-items-center justify-content-end gap-1 mb-0">
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <p class="fs-4 mb-0 text-dark">
                The dashboard template from adminmart has helped me
                provide a clean and sleek look to my dashboard and made
                it look exactly the way I wanted it to, mainly without
                having.
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between mb-4">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('web/assets/images/profile/user-2.jpg') }}" alt="modernize-img" class="w-auto me-3 rounded-circle" width="40" height="40" />
                  <div>
                    <h6 class="fs-4 mb-1 fw-semibold">Minshan Cui</h6>
                    <p class="mb-0 text-dark">Features avaibility</p>
                  </div>
                </div>
                <div>
                  <ul class="list-unstyled d-flex align-items-center justify-content-end gap-1 mb-0">
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <p class="fs-4 text-dark mb-0">
                The quality of design is excellent, customizability and
                flexibility much better than the other products
                available in the market. I strongly recommend the
                AdminMart to other buyers.
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between mb-4">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('web/assets/images/profile/user-3.jpg') }}" alt="modernize-img" class="w-auto me-3 rounded-circle" width="40" height="40" />
                  <div>
                    <h6 class="fs-4 mb-1 fw-semibold">
                      Eminson Mendoza
                    </h6>
                    <p class="mb-0 fw-normal">Features avaibility</p>
                  </div>
                </div>
                <div>
                  <ul class="list-unstyled d-flex align-items-center justify-content-end gap-1 mb-0">
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <p class="fs-4 text-dark mb-0">
                This template is great, UI-rich and up-to-date. Although
                it is pretty much complete, I suggest to improve a bit
                of documentation. Thanks & Highly recomended!
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between mb-4">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('web/assets/images/profile/user-1.jpg') }}" alt="modernize-img" class="w-auto me-3 rounded-circle" width="40" height="40" />
                  <div>
                    <h6 class="fs-4 mb-1 fw-semibold">Jenny Wilson</h6>
                    <p class="mb-0 text-dark">Features avaibility</p>
                  </div>
                </div>
                <div>
                  <ul class="list-unstyled d-flex align-items-center justify-content-end gap-1 mb-0">
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <p class="fs-4 mb-0 text-dark">
                The dashboard template from adminmart has helped me
                provide a clean and sleek look to my dashboard and made
                it look exactly the way I wanted it to, mainly without
                having.
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between mb-4">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('web/assets/images/profile/user-2.jpg') }}" alt="modernize-img" class="w-auto me-3 rounded-circle" width="40" height="40" />
                  <div>
                    <h6 class="fs-4 mb-1 fw-semibold">Minshan Cui</h6>
                    <p class="mb-0 text-dark">Features avaibility</p>
                  </div>
                </div>
                <div>
                  <ul class="list-unstyled d-flex align-items-center justify-content-end gap-1 mb-0">
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <p class="fs-4 text-dark mb-0">
                The quality of design is excellent, customizability and
                flexibility much better than the other products
                available in the market. I strongly recommend the
                AdminMart to other buyers.
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between mb-4">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('web/assets/images/profile/user-3.jpg') }}" alt="modernize-img" class="w-auto me-3 rounded-circle" width="40" height="40" />
                  <div>
                    <h6 class="fs-4 mb-1 fw-semibold">
                      Eminson Mendoza
                    </h6>
                    <p class="mb-0 fw-normal">Features avaibility</p>
                  </div>
                </div>
                <div>
                  <ul class="list-unstyled d-flex align-items-center justify-content-end gap-1 mb-0">
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <p class="fs-4 text-dark mb-0">
                This template is great, UI-rich and up-to-date. Although
                it is pretty much complete, I suggest to improve a bit
                of documentation. Thanks & Highly recomended!
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between mb-4">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('web/assets/images/profile/user-1.jpg') }}" alt="modernize-img" class="w-auto me-3 rounded-circle" width="40" height="40" />
                  <div>
                    <h6 class="fs-4 mb-1 fw-semibold">Jenny Wilson</h6>
                    <p class="mb-0 text-dark">Features avaibility</p>
                  </div>
                </div>
                <div>
                  <ul class="list-unstyled d-flex align-items-center justify-content-end gap-1 mb-0">
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <p class="fs-4 mb-0 text-dark">
                The dashboard template from adminmart has helped me
                provide a clean and sleek look to my dashboard and made
                it look exactly the way I wanted it to, mainly without
                having.
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between mb-4">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('web/assets/images/profile/user-2.jpg') }}" alt="modernize-img" class="w-auto me-3 rounded-circle" width="40" height="40" />
                  <div>
                    <h6 class="fs-4 mb-1 fw-semibold">Minshan Cui</h6>
                    <p class="mb-0 text-dark">Features avaibility</p>
                  </div>
                </div>
                <div>
                  <ul class="list-unstyled d-flex align-items-center justify-content-end gap-1 mb-0">
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <p class="fs-4 text-dark mb-0">
                The quality of design is excellent, customizability and
                flexibility much better than the other products
                available in the market. I strongly recommend the
                AdminMart to other buyers.
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between mb-4">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('web/assets/images/profile/user-3.jpg') }}" alt="modernize-img" class="w-auto me-3 rounded-circle" width="40" height="40" />
                  <div>
                    <h6 class="fs-4 mb-1 fw-semibold">
                      Eminson Mendoza
                    </h6>
                    <p class="mb-0 fw-normal">Features avaibility</p>
                  </div>
                </div>
                <div>
                  <ul class="list-unstyled d-flex align-items-center justify-content-end gap-1 mb-0">
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <p class="fs-4 text-dark mb-0">
                This template is great, UI-rich and up-to-date. Although
                it is pretty much complete, I suggest to improve a bit
                of documentation. Thanks & Highly recomended!
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between mb-4">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('web/assets/images/profile/user-1.jpg') }}" alt="modernize-img" class="w-auto me-3 rounded-circle" width="40" height="40" />
                  <div>
                    <h6 class="fs-4 mb-1 fw-semibold">Jenny Wilson</h6>
                    <p class="mb-0 text-dark">Features avaibility</p>
                  </div>
                </div>
                <div>
                  <ul class="list-unstyled d-flex align-items-center justify-content-end gap-1 mb-0">
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <p class="fs-4 mb-0 text-dark">
                The dashboard template from adminmart has helped me
                provide a clean and sleek look to my dashboard and made
                it look exactly the way I wanted it to, mainly without
                having.
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between mb-4">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('web/assets/images/profile/user-2.jpg') }}" alt="modernize-img" class="w-auto me-3 rounded-circle" width="40" height="40" />
                  <div>
                    <h6 class="fs-4 mb-1 fw-semibold">Minshan Cui</h6>
                    <p class="mb-0 text-dark">Features avaibility</p>
                  </div>
                </div>
                <div>
                  <ul class="list-unstyled d-flex align-items-center justify-content-end gap-1 mb-0">
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <p class="fs-4 text-dark mb-0">
                The quality of design is excellent, customizability and
                flexibility much better than the other products
                available in the market. I strongly recommend the
                AdminMart to other buyers.
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between mb-4">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('web/assets/images/profile/user-3.jpg') }}" alt="modernize-img" class="w-auto me-3 rounded-circle" width="40" height="40" />
                  <div>
                    <h6 class="fs-4 mb-1 fw-semibold">
                      Eminson Mendoza
                    </h6>
                    <p class="mb-0 fw-normal">Features avaibility</p>
                  </div>
                </div>
                <div>
                  <ul class="list-unstyled d-flex align-items-center justify-content-end gap-1 mb-0">
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <p class="fs-4 text-dark mb-0">
                This template is great, UI-rich and up-to-date. Although
                it is pretty much complete, I suggest to improve a bit
                of documentation. Thanks & Highly recomended!
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between mb-4">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('web/assets/images/profile/user-1.jpg') }}" alt="modernize-img" class="w-auto me-3 rounded-circle" width="40" height="40" />
                  <div>
                    <h6 class="fs-4 mb-1 fw-semibold">Jenny Wilson</h6>
                    <p class="mb-0 text-dark">Features avaibility</p>
                  </div>
                </div>
                <div>
                  <ul class="list-unstyled d-flex align-items-center justify-content-end gap-1 mb-0">
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <p class="fs-4 mb-0 text-dark">
                The dashboard template from adminmart has helped me
                provide a clean and sleek look to my dashboard and made
                it look exactly the way I wanted it to, mainly without
                having.
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between mb-4">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('web/assets/images/profile/user-2.jpg') }}" alt="modernize-img" class="w-auto me-3 rounded-circle" width="40" height="40" />
                  <div>
                    <h6 class="fs-4 mb-1 fw-semibold">Minshan Cui</h6>
                    <p class="mb-0 text-dark">Features avaibility</p>
                  </div>
                </div>
                <div>
                  <ul class="list-unstyled d-flex align-items-center justify-content-end gap-1 mb-0">
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <p class="fs-4 text-dark mb-0">
                The quality of design is excellent, customizability and
                flexibility much better than the other products
                available in the market. I strongly recommend the
                AdminMart to other buyers.
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between mb-4">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('web/assets/images/profile/user-3.jpg') }}" alt="modernize-img" class="w-auto me-3 rounded-circle" width="40" height="40" />
                  <div>
                    <h6 class="fs-4 mb-1 fw-semibold">
                      Eminson Mendoza
                    </h6>
                    <p class="mb-0 fw-normal">Features avaibility</p>
                  </div>
                </div>
                <div>
                  <ul class="list-unstyled d-flex align-items-center justify-content-end gap-1 mb-0">
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <img src="{{ asset('web/assets/images/svgs/icon-star.svg') }}" alt="modernize-img" class="img-fluid" />
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <p class="fs-4 text-dark mb-0">
                This template is great, UI-rich and up-to-date. Although
                it is pretty much complete, I suggest to improve a bit
                of documentation. Thanks & Highly recomended!
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="posts-section py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <h2 class="fs-9 text-center mb-4 mb-lg-5 fw-bolder" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
          Lo último de nuestro Blog
        </h2>
      </div>
    </div>
    <div class="post-list" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
      <div class="row">
        @foreach ($entradas as $ent)
        <div class="col-lg-4 col-md-6">
          <div class="card overflow-hidden hover-img">
            <div class="position-relative">
              <a href="javascript:void(0)">
                <img src="/storage/files/{{ $ent->imagen }}" class="card-img-top" alt="modernize-img">
              </a>
              <img src="{{ asset('web/assets/images/profile/user-3.jpg') }}" alt="modernize-img" class="img-fluid rounded-circle position-absolute bottom-0 start-0 mb-n9 ms-9" width="40" height="40" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $ent->autor }}">
            </div>
            <div class="card-body p-4">
              <div class="d-block">
                @php
                  $categorias = explode(',',$ent->categorias);
                @endphp
                @foreach ($categorias as $cat)
                <a href="{{ route('posts',['categoria'=>$cat]) }}" class="badge text-bg-light fs-2 py-1 px-2 lh-sm mt-3 me-1">{{ $cat }}</a>
                @endforeach
              </div>
              <a class="d-block my-4 fs-5 text-dark fw-semibold link-primary" href="javascript:void(0)">{{ $ent->titulo }}</a>
              <div class="d-flex align-items-center gap-4">
                <div class="d-flex align-items-center gap-2">
                  <i class="ti ti-eye text-dark fs-5"></i>9,125
                </div>
                <div class="d-flex align-items-center gap-2">
                  <i class="ti ti-message-2 text-dark fs-5"></i>3
                </div>
                <div class="d-flex align-items-center gap-2">
                  @php
                    \Carbon\Carbon::setLocale('es');
                    $date = \Carbon\Carbon::parse($ent->fecha_publicacion);
                    $formattedDate = $date->translatedFormat('D, M d - Y');
                    $formattedDate = ucwords($formattedDate);
                  @endphp
                  <i class="ti ti-calendar-event text-dark fs-5"></i>{{ $formattedDate }}
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
<section class="py-md-5 mb-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card c2a-box" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
          <div class="card-body text-center p-4 pt-7">
            <h3 class="fs-7 fw-semibold pt-6">
              ¿Buscas más ejemplos de mi código?
            </h3>
            <p class="mb-7 pb-2 text-dark">
              Revisa nuestros repositorios de gitlab y github para más ejemplos de código.
            </p>
            <div class="d-sm-flex align-items-center justify-content-center gap-3 mb-4">
              <a href="#" target="_blank" class="btn btn-primary d-block mb-3 mb-sm-0 btn-hover-shadow px-7 py-6" type="button">Visitar Gitlab</a>
              <a href="#" target="_blank" class="btn btn-outline-secondary d-block px-7 py-6" type="button">Visitar Github</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('web/assets/libs/jquery-raty-js/lib/jquery.raty.js') }}"></script>
<script>
  @foreach ($productos as $prod)
  $("#rating-{{ $prod->id }}").raty({
    score: {{ $prod->puntuacion }},
    readOnly: true,
    half: true,
    starHalf: "{{ asset('web/assets/images/rating/star-half-xs.png') }}",
    starOff: "{{ asset('web/assets/images/rating/star-off-xs.png') }}",
    starOn: "{{ asset('web/assets/images/rating/star-on-xs.png') }}",
  });
  @endforeach

  @foreach ($cursos as $cur)
  $("#rating-c-{{ $cur->id }}").raty({
    score: 4.3,
    readOnly: true,
    half: true,
    starHalf: "{{ asset('web/assets/images/rating/star-half-xs.png') }}",
    starOff: "{{ asset('web/assets/images/rating/star-off-xs.png') }}",
    starOn: "{{ asset('web/assets/images/rating/star-on-xs.png') }}",
  });
  @endforeach
</script>
@endsection