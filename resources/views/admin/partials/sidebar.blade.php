<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
    <div class="sidebar-brand-icon">
      <svg width="45" height="45" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 10px;">
        <!-- Cloud/flower outline shape with red border and white fill -->
        <path d="M25 8 C28 8, 31 9, 33 11 C35 13, 36 16, 36 19 C38 20, 39 22, 39 25 C39 28, 38 30, 36 31 C36 34, 35 37, 33 39 C31 41, 28 42, 25 42 C22 42, 19 41, 17 39 C15 37, 14 34, 14 31 C12 30, 11 28, 11 25 C11 22, 12 20, 14 19 C14 16, 15 13, 17 11 C19 9, 22 8, 25 8 Z" stroke="#DC143C" stroke-width="2.5" fill="#FFFFFF"/>
        <!-- Red cross -->
        <rect x="23" y="18" width="4" height="14" fill="#DC143C" rx="0.5"/>
        <rect x="18" y="23" width="14" height="4" fill="#DC143C" rx="0.5"/>
      </svg>
    </div>
    <div class="sidebar-brand-text mx-3">Admin Donasi PMI</div>
  </a>
  <hr class="sidebar-divider my-0">
  
  <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>
  
  <hr class="sidebar-divider">
  <div class="sidebar-heading">
    Menu Utama
  </div>
  
  <li class="nav-item {{ request()->routeIs('admin.donasi.*') ? 'active' : '' }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDonasi"
      aria-expanded="true" aria-controls="collapseDonasi">
      <i class="fas fa-fw fa-hand-holding-heart"></i>
      <span>Laporan Donasi</span>
    </a>
    <div id="collapseDonasi" class="collapse {{ request()->routeIs('admin.donasi.*') ? 'show' : '' }}" aria-labelledby="headingDonasi" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Laporan</h6>
        <a class="collapse-item {{ request()->routeIs('admin.donasi.laporan') ? 'active' : '' }}" href="{{ route('admin.donasi.laporan') }}">Pemasukan</a>
        <a class="collapse-item {{ request()->routeIs('admin.donasi.pengeluaran*') ? 'active' : '' }}" href="{{ route('admin.donasi.pengeluaran.index') }}">Pengeluaran</a>
      </div>
    </div>
  </li>
  
  <li class="nav-item {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBerita" aria-expanded="true"
      aria-controls="collapseBerita">
      <i class="fas fa-fw fa-newspaper"></i>
      <span>Berita</span>
    </a>
    <div id="collapseBerita" class="collapse {{ request()->routeIs('admin.berita.*') ? 'show' : '' }}" aria-labelledby="headingBerita" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Berita</h6>
        <a class="collapse-item {{ request()->routeIs('admin.berita.create') ? 'active' : '' }}" href="{{ route('admin.berita.create') }}">
          <i class="fas fa-plus"></i> Tambah Berita
        </a>
        <a class="collapse-item {{ request()->routeIs('admin.berita.index') && !request()->routeIs('admin.berita.create') && !request()->routeIs('admin.berita.kategori.*') ? 'active' : '' }}" href="{{ route('admin.berita.index') }}">
          <i class="fas fa-list"></i> List Berita
        </a>
        <a class="collapse-item {{ request()->routeIs('admin.berita.kategori.*') ? 'active' : '' }}" href="{{ route('admin.berita.kategori.index') }}">
          <i class="fas fa-tags"></i> Kategori
        </a>
      </div>
    </div>
  </li>
  
  <li class="nav-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.gallery.index') }}">
      <i class="fas fa-fw fa-images"></i>
      <span>Gallery</span>
    </a>
  </li>
  
  <li class="nav-item {{ request()->routeIs('admin.laporan-keuangan.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.laporan-keuangan.index') }}">
      <i class="fas fa-fw fa-chart-line"></i>
      <span>Laporan Keuangan</span>
    </a>
  </li>
  
  <li class="nav-item {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.user.index') }}">
      <i class="fas fa-fw fa-users"></i>
      <span>Data User</span>
    </a>
  </li>
  
  <hr class="sidebar-divider">
  <div class="version" id="version-ruangadmin"></div>
</ul>
<!-- Sidebar -->

