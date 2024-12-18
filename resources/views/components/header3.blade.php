<aside class="left-sidebar with-vertical">
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="{{ route('index') }}" class="text-nowrap logo-img">
        <img src="{{ asset('web/assets/images/logos/dark-logo.svg') }}" class="dark-logo" alt="Logo-Dark" />
        <img src="{{ asset('web/assets/images/logos/light-logo.svg') }}" class="light-logo" alt="Logo-light" />
      </a>
      <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
        <i class="ti ti-x"></i>
      </a>
    </div>

    <nav class="sidebar-nav scroll-sidebar" data-simplebar>
      <ul id="sidebarnav">
        @foreach ($sections as $section)
          @if (isset($section['items']))
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">{{ $section['nombre'] }}</span>
            </li>
            @foreach ($section['items'] as $item)
              <li class="sidebar-item">
                <a class="sidebar-link" href="{{ $item['url'] }}" aria-expanded="false">
                  <span>
                    <i class="ti {{ $item['icono'] }}"></i>
                  </span>
                  <span class="hide-menu">{{ $item['nombre'] }}</span>
                </a>
              </li>
            @endforeach
          @else
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">{{ $section['nombre'] }}</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ $section['url'] }}" aria-expanded="false">
              <span>
                <i class="ti {{ $section['icono'] }}"></i>
              </span>
              <span class="hide-menu">{{ $section['nombre'] }}</span>
            </a>
          </li>
          @endif
        @endforeach
      </ul>
    </nav>

    <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
      <div class="hstack gap-3">
        <div class="john-img">
          <img src="{{ asset('web/assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="40" height="40" alt="modernize-img" />
        </div>
        <div class="john-title">
          <h6 class="mb-0 fs-4 fw-semibold">Mathew</h6>
          <span class="fs-2">Designer</span>
        </div>
        <button class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button" aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
          <i class="ti ti-power fs-6"></i>
        </button>
      </div>
    </div>

    <!-- ---------------------------------- -->
    <!-- Start Vertical Layout Sidebar -->
    <!-- ---------------------------------- -->
  </div>
</aside>