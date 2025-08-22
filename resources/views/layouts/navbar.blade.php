{{-- resources/views/layouts/navbar.blade.php --}}
<nav class="navbar navbar-expand navbar-light topbar static-top mb-4 bg-white shadow">

  <!-- Sidebar Toggle (Mobile) -->
  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
  </button>

  <!-- Topbar Search (desktop) -->
  <form class="d-none d-sm-inline-block form-inline ml-md-3 my-md-0 mw-100 navbar-search my-2 mr-auto">
    <div class="input-group">
      <input type="text" class="form-control bg-light small border-0" placeholder="Search…" aria-label="Search"
        aria-describedby="topbar-search">
      <div class="input-group-append">
        <button class="btn btn-primary" type="button" id="topbar-search">
          <i class="fas fa-search fa-sm"></i>
        </button>
      </div>
    </div>
  </form>

  <ul class="navbar-nav ml-auto">

    <!-- Search (xs dropdown) -->
    <li class="nav-item dropdown no-arrow d-sm-none">
      <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-search fa-fw"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-right animated--grow-in p-3 shadow" aria-labelledby="searchDropdown">
        <form class="form-inline w-100 navbar-search">
          <div class="input-group">
            <input type="text" class="form-control bg-light small border-0" placeholder="Search…"
              aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-primary" type="button">
                <i class="fas fa-search fa-sm"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </li>

    <!-- Alerts (optional) -->
    <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <span class="badge badge-danger badge-counter d-none" id="alertsCount"></span>
      </a>
      <div class="dropdown-menu dropdown-menu-right animated--grow-in shadow" aria-labelledby="alertsDropdown">
        <span class="dropdown-item small text-gray-500">Tidak ada notifikasi</span>
      </div>
    </li>

    <!-- Messages (optional) -->
    <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-envelope fa-fw"></i>
        <span class="badge badge-danger badge-counter d-none" id="messagesCount"></span>
      </a>
      <div class="dropdown-menu dropdown-menu-right animated--grow-in shadow" aria-labelledby="messagesDropdown">
        <span class="dropdown-item small text-gray-500">Tidak ada pesan</span>
      </div>
    </li>

    <div class="topbar-divider d-none d-sm-block"></div>

    <!-- User -->
    @php
      $user = auth('admin')->user() ?? (auth('dosen')->user() ?? (auth('mahasiswa')->user() ?? auth()->user()));
      $displayName = $user->name ?? ($user->nama ?? 'User');
      $level =
          $user->level ??
          (auth('admin')->check()
              ? 'Admin'
              : (auth('dosen')->check()
                  ? 'Dosen'
                  : (auth('mahasiswa')->check()
                      ? 'Mahasiswa'
                      : '')));
    @endphp
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <span class="d-none d-lg-inline small mr-2 text-gray-600">
          {{ $displayName }} @if ($level)
            <br><small>{{ $level }}</small>
          @endif
        </span>
        <img class="img-profile rounded-circle"
          src="https://startbootstrap.github.io/startbootstrap-sb-admin-2/img/undraw_profile.svg" alt="Profile">
      </a>
      <div class="dropdown-menu dropdown-menu-right animated--grow-in shadow" aria-labelledby="userDropdown">
        <a class="dropdown-item">
          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile
        </a>
        <a class="dropdown-item" href="#">
          <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Settings
        </a>
        <a class="dropdown-item" href="#">
          <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Activity Log
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ route('logout') }}">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
        </a>
      </div>
    </li>
  </ul>
</nav>
