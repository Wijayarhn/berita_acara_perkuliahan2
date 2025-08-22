<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dosen.jadwal.index') }}">
    <div class="sidebar-brand-icon">
      {{-- <img src="{{ asset('admin_assets/img/bina-bangsa.jpeg') }}" alt="Logo" width="50"> --}}
    </div>
    <div class="sidebar-brand-text mx-3">BAP - Dosen</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <li class="nav-item">
    <a class="nav-link" href="{{ route('dosen.dashboard') }}">
      <i class="fas fa-fw fa-calendar-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <!-- 📋 Jadwal Mengajar -->
  <li class="nav-item">
    <a class="nav-link" href="{{ route('dosen.jadwal.index') }}">
      <i class="fas fa-fw fa-calendar-alt"></i>
      <span>Jadwal Mengajar</span>
    </a>
  </li>

  <!-- 📝 Buat BAP -->
  {{-- Link ini biasanya lewat tombol di jadwal detail, tapi kalau ingin eksplisit: --}}
  {{-- <li class="nav-item">
    <a class="nav-link" href="{{ route('dosen.bap.create') }}">
      <i class="fas fa-fw fa-plus-circle"></i>
      <span>Buat BAP</span>
    </a>
  </li> --}}

  <!-- 📝 Berita Acara -->
  <li class="nav-item">
    <a class="nav-link" href="{{ route('dosen.bap.index') }}">
      <i class="fas fa-fw fa-file-alt"></i>
      <span>Manajemen BAP</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('dosen.reports.index') }}">
      <i class="fas fa-fw fa-file-alt"></i>
      <span>Reports</span>
    </a>
  </li>

  <!-- ⚙️ Profile -->
  a

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler -->
  <div class="d-none d-md-inline text-center">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
