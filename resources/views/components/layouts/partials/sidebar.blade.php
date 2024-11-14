<aside class="main-sidebar sidebar-light-primary elevation-4">
  <a href="/home" class="brand-link">
    <img src="assets/dist/img/itech.jpg" alt="Logo" class="brand-image img-fluid">
    <span class="brand-text font-weight-light"><b>E-Surat</b></span>
  </a>

  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ Auth::user()->profile_picture ? asset('storage/profile_pictures/' . Auth::user()->profile_picture) : asset('assets/dist/img/default.png') }}"
        class="img-circle elevation-2" alt="User Image">
      </div>

      <div class="info">
        @if(Auth::check())
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        @else
          <a href="#" class="d-block">Guest</a>
        @endif
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
              <a href="/home" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>Dashboard</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="/dosen" class="nav-link">
                  <i class="nav-icon fas fa-solid fa-file"></i>
                  <p>Surat Dosen</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="/laporan" class="nav-link">
                  <i class="nav-icon fas fa-solid fa-folder"></i>
                  <p>Laporan</p>
              </a>
          </li>
      </ul>
    </nav>
  </div>
</aside>