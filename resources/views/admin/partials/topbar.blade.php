<!-- TopBar -->
<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
  <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
    <i class="fa fa-bars"></i>
  </button>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-envelope fa-fw"></i>
        @php
          $donasiBaru = \App\Models\Donasi::whereDate('created_at', today())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        @endphp
        @if($donasiBaru->count() > 0)
        <span class="badge badge-warning badge-counter">{{ $donasiBaru->count() }}</span>
        @endif
      </a>
      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
        aria-labelledby="messagesDropdown" style="width: 20rem;">
        <h6 class="dropdown-header" style="background-color: #f8f9fc; color: #5a5c69; font-weight: 600; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 0.1rem;">
          Notifikasi Donasi Masuk
        </h6>
        @if($donasiBaru->count() > 0)
          @foreach($donasiBaru as $donasi)
          <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.donasi.laporan') }}" style="color: #5a5c69; padding: 0.75rem 1rem; border-bottom: 1px solid #e3e6f0;">
            <div class="dropdown-list-image mr-3">
              <div class="icon-circle bg-success" style="width: 2.5rem; height: 2.5rem; border-radius: 100%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-hand-holding-heart text-white"></i>
              </div>
            </div>
            <div style="flex: 1; min-width: 0;">
              <div class="text-truncate font-weight-bold" style="color: #5a5c69; font-size: 0.875rem;">
                Donasi dari {{ $donasi->nama }}
              </div>
              <div class="small" style="color: #858796; font-size: 0.75rem;">
                Rp {{ number_format($donasi->nominal ?? $donasi->jumlah ?? 0, 0, ',', '.') }} · 
                {{ $donasi->created_at->diffForHumans() }}
              </div>
            </div>
          </a>
          @endforeach
          <a class="dropdown-item text-center small" href="{{ route('admin.donasi.laporan') }}" style="color: #4e73df; padding: 0.5rem 1rem; font-weight: 600; border-top: 1px solid #e3e6f0;">
            Lihat Semua Donasi
          </a>
        @else
          <a class="dropdown-item text-center small" style="color: #858796; padding: 1rem;">
            Tidak ada donasi baru hari ini
          </a>
        @endif
      </div>
    </li>
    <div class="topbar-divider d-none d-sm-block"></div>
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <img class="img-profile rounded-circle" src="{{ asset('assets/admin/img/boy.png') }}" style="width: 40px; height: 40px; object-fit: cover;">
        <span class="ml-2 d-none d-lg-inline text-white small" style="max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ auth()->user()->name ?? 'Admin' }}</span>
      </a>
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="#">
          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
          Profil
        </a>
        <a class="dropdown-item" href="#">
          <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
          Pengaturan
        </a>
        <a class="dropdown-item" href="#">
          <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
          Log Aktifitas
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          Logout
        </a>
      </div>
    </li>
  </ul>
</nav>
<!-- Topbar -->

