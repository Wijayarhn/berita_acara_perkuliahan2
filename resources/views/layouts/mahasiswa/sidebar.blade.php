<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('mahasiswa.dashboard') }}">
    <div class="sidebar-brand-icon">
      {{-- <img src="{{ asset('admin_assets/img/bina-bangsa.jpeg') }}" alt="Logo" width="50"> --}}
    </div>
    <div class="sidebar-brand-text mx-3">BAP - Mahasiswa</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- 🏠 Dashboard -->
  <li class="nav-item">
    <a class="nav-link" href="{{ route('mahasiswa.dashboard') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <!-- 📅 Jadwal Kuliah (optional) -->
  <li class="nav-item">
    <a class="nav-link" href="{{ route('mahasiswa.jadwal.index') }}">
      <i class="fas fa-fw fa-calendar-alt"></i>
      <span>Jadwal Kuliah</span>
    </a>
  </li>

  <!-- ✍️ TTD BAP -->
  <li class="nav-item">
    <a class="nav-link" href="{{ route('mahasiswa.bap.index') }}">
      <i class="fas fa-fw fa-pen-fancy"></i>
      <span>Berita Acara Aktif</span>
    </a>
  </li>
  <!-- 📜 Riwayat TTD BAP -->
  <li class="nav-item">
    <a class="nav-link" href="{{ route('mahasiswa.bap.riwayat') }}">
      <i class="fas fa-fw fa-history"></i>
      <span>Riwayat TTD BAP</span>
    </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler -->
  <div class="d-none d-md-inline text-center">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
