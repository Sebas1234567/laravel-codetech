@extends('layout.web')
@section('titulo'){{ $categoria }} - CodeTech @stop

@section('styles')
@stop

@section('content')
<div class="container-fluid mb-4 pt-lg-20">
  <div class="card bg-primary-subtle-2 shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
      <div class="row align-items-center">
        <div class="col-9">
          <h4 class="fw-semibold mb-8">{{ $categoria }}</h4>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a class="text-muted text-decoration-none" href="{{ route('index') }}">Inicio</a>
              </li>
              <li class="breadcrumb-item" aria-current="page">Blog</li>
            </ol>
          </nav>
        </div>
        <div class="col-3">
          <div class="text-center mb-n5">
            <img src="{{ asset('web/assets/images/breadcrumb/ChatBc.png') }}" alt="modernize-img" class="img-fluid mb-n4" />
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    @foreach ($entradas as $ent)
    <div class="col-md-6 col-lg-4">
      <div class="card overflow-hidden hover-img">
        <div class="position-relative">
          <a href="#">
            <img src="/storage/files/{{ $ent->imagen }}" class="card-img-top" alt="modernize-img">
          </a>
          <img src="{{ asset('web/assets/images/profile/user-3.jpg') }}" alt="modernize-img" class="img-fluid rounded-circle position-absolute bottom-0 start-0 mb-n9 ms-9" width="40" height="40" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $ent->autor }}">
        </div>
        <div class="card-body p-4">
          @php
            $categorias = explode(',',$ent->categorias);
          @endphp
          @foreach ($categorias as $cat)
          <a href="{{ route('posts',['categoria'=>$cat,]) }}" class="badge text-bg-light fs-2 py-1 px-2 lh-sm mt-3 me-1">{{ $cat }}</a>
          @endforeach
          <a class="d-block my-4 fs-5 text-dark fw-semibold link-primary" href="#">{{ $ent->titulo }}</a>
          <div class="d-flex align-items-center gap-4">
            <div class="d-flex align-items-center gap-2">
              <i class="ti ti-heart text-dark fs-5"></i>9,125
            </div>
            <div class="d-flex align-items-center gap-2">
              <i class="ti ti-message-2 text-dark fs-5"></i>3
            </div>
            <div class="d-flex align-items-center gap-2 ms-auto">
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
  <nav aria-label="...">
    <ul class="pagination justify-content-center mb-0 mt-4">
      <li class="page-item">
        <a class="page-link border-0 rounded-circle text-dark round-32 d-flex align-items-center justify-content-center @if ($entradas->onFirstPage())disabled @endif" href="{{ $entradas->previousPageUrl() }}">
          <i class="ti ti-chevron-left"></i>
        </a>
      </li>
      @for ($i=1; $i < $entradas->lastPage()+1; $i++)
      <li class="page-item @if ($i == $entradas->currentPage())active @endif" aria-current="page">
        <a class="page-link border-0 rounded-circle round-32 mx-2 d-flex align-items-center justify-content-center" href="{{ $entradas->url($i) }}">{{ $i }}</a>
      </li>
      @endfor
      <li class="page-item">
        <a class="page-link border-0 rounded-circle text-dark round-32 d-flex align-items-center justify-content-center @if ($entradas->lastPage() == $entradas->currentPage())disabled @endif" href="{{ $entradas->nextPageUrl() }}">
          <i class="ti ti-chevron-right"></i>
        </a>
      </li>
    </ul>
  </nav>
</div>
@stop

@section('scripts')
@stop