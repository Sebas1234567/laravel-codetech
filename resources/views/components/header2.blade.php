<aside class="left-sidebar with-horizontal">
  <!-- Sidebar scroll-->
  <div>
    <!-- Sidebar navigation-->
    <nav id="sidebarnavh" class="sidebar-nav scroll-sidebar container-fluid">
      <ul id="sidebarnav">
        @foreach ($sections as $section)
          @if (isset($section['items']))
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">{{ $section['nombre'] }}</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <span>
                  <i class="ti {{ $section['icono'] }}"></i>
                </span>
                <span class="hide-menu">{{ $section['nombre'] }}</span>
              </a>
              <ul aria-expanded="false" class="collapse first-level">
                @foreach ($section['items'] as $item)
                <li class="sidebar-item">
                  <a href="{{ $item['url'] }}" class="sidebar-link">
                    <i class="ti {{ $item['icono'] }}"></i>
                    <span class="hide-menu">{{ $item['nombre'] }}</span>
                  </a>
                </li>
                @endforeach
              </ul>
            </li>
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
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->

</aside>