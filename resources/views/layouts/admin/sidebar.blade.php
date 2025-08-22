<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.jadwal.index') }}">
    <div class="sidebar-brand-icon">
      <img src="{{ asset('admin_assets/img/binabangsa.png') }}" alt="Bina Bangsa Logo" width="40">
    </div>
    <div class="sidebar-brand-text mx-3 text-left">BAP Online</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- ⚙️ Laporan BAP -->
  {{-- Uncomment jika route laporan tersedia --}}
  <li class="nav-item {{ request()->routeIs('admin.dashboard.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">
      <i class="fas fa-chart-bar"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <!-- 👥 Manajemen User -->
  {{-- Uncomment jika fitur user tersedia --}}
  <li class="nav-item {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.user.index') }}">
      <i class="fas fa-users-cog"></i>
      <span>Manajemen User</span>
    </a>
  </li>
  <!-- 📅 Jadwal -->
  <li class="nav-item {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.jadwal.index') }}">
      <i class="fas fa-calendar-alt"></i>
      <span>Manajemen Jadwal</span>
    </a>
  </li>

  <!-- ✅ Verifikasi BAP -->
  <li class="nav-item {{ request()->routeIs('admin.bap.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.bap.index') }}">
      <i class="fas fa-file-alt"></i>
      <span>Verifikasi BAP</span>
    </a>
  </li>
  <li class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.reports.dosen.index') }}">
      <i class="fas fa-file-alt"></i>
      <span>Reports</span>
    </a>
  </li>

  {{-- <li class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('dosen') }}">
      <i class="fas fa-file-invoice"></i>
      <span>Reports</span>
    </a>
  </li> --}}

  <!-- ⚙️ Laporan BAP -->
  {{-- Uncomment jika route laporan tersedia --}}
  {{-- <li class="nav-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.laporan.bap') }}">
      <i class="fas fa-chart-bar"></i>
      <span>Laporan BAP</span>
    </a>
  </li> --}}

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler -->
  <div class="d-none d-md-inline text-center">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
