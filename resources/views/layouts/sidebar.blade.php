<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
      <!--begin::Brand Link-->
      <a href="./index.html" class="brand-link">
        <!--begin::Brand Image-->
        {{-- <img
          src="{{ asset('/') }}assets/img/AdminLTELogo.png"
          alt="AdminLTE Logo"
          class="brand-image opacity-75 shadow"
        /> --}}
        <!--end::Brand Image-->
        <!--begin::Brand Text-->
        <span class="brand-text fw-light">E-COURSES</span>
        <!--end::Brand Text-->
      </a>
      <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
      <nav class="mt-2">
        <!--begin::Sidebar Menu-->
        <ul
          class="nav sidebar-menu flex-column"
          data-lte-toggle="treeview"
          role="menu"
          data-accordion="false"
        >
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link @if(Route::is('home') ) active @endif">
              <i class="nav-icon fas fa-home"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('modules.index') }}" class="nav-link @if(Route::is('modules.*') ) active @endif">
              <i class="nav-icon fas fa-book"></i>
              <p>Module Belajar</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('records.index') }}" class="nav-link @if(Route::is('records.*') ) active @endif">
              <i class="nav-icon fas fa-video"></i>
              <p>Rekaman Kelas</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('files.index') }}" class="nav-link @if(Route::is('files.*') ) active @endif">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>Bahan Ajar Tutor</p>
            </a>
          </li>
          @role('admin')
          <li class="nav-item">
            <a href="{{ route('groups.index') }}" class="nav-link @if(Route::is('groups.*') ) active @endif">
              <i class="nav-icon bi bi-palette"></i>
              <p>Daftar Kelas</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('cert.index') }}" class="nav-link @if(Route::is('cert.*') ) active @endif">
              <i class="nav-icon bi bi-palette"></i>
              <p>E-Sertifikat</p>
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
                <i class="nav-arrow bi bi-chevron-right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link @if(Route::is('users.*') ) active @endif">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('roles.index') }}" class="nav-link @if(Route::is('roles.*') ) active @endif">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Roles</p>
                </a>
              </li>
            </ul>
          </li>
          @endrole
          
        </ul>
        <!--end::Sidebar Menu-->
      </nav>
    </div>
    <!--end::Sidebar Wrapper-->
  </aside>
  <!--end::Sidebar-->