<!-- TopBar -->
<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top" style="z-index: 1050;">
    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <style>
        #userMenu {
            position: fixed;
            top: 60px;
            right: 20px;
            z-index: 999999;
        }


        .navbar {
            position: relative;
            z-index: 1000;
        }
    </style>

    <ul class="navbar-nav ml-auto">

        <!-- NOTIFIKASI -->
        <li class="nav-item dropdown mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>

                @php
                    $donasiBaru = \App\Models\Donasi::whereDate('created_at', today())
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
                @endphp

                @if ($donasiBaru->count() > 0)
                    <span class="badge badge-warning badge-counter">{{ $donasiBaru->count() }}</span>
                @endif
            </a>

            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown"
                style="width: 20rem;">

                <h6 class="dropdown-header bg-light text-dark font-weight-bold text-uppercase small">
                    Notifikasi Donasi Masuk
                </h6>

                @forelse ($donasiBaru as $donasi)
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.donasi.laporan') }}">
                        <div class="mr-3">
                            <div class="icon-circle bg-success">
                                <i class="fas fa-hand-holding-heart text-white"></i>
                            </div>
                        </div>
                        <div class="flex-fill">
                            <div class="font-weight-bold text-truncate">
                                Donasi dari {{ $donasi->nama }}
                            </div>
                            <div class="small text-muted">
                                Rp {{ number_format($donasi->nominal ?? ($donasi->jumlah ?? 0), 0, ',', '.') }}
                                · {{ $donasi->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </a>
                @empty
                    <span class="dropdown-item text-center text-muted">
                        Tidak ada donasi baru hari ini
                    </span>
                @endforelse

                <div class="dropdown-divider"></div>

                <a class="dropdown-item text-center text-primary font-weight-bold"
                    href="{{ route('admin.donasi.laporan') }}">
                    Lihat Semua Donasi
                </a>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- USER MENU -->
        <!-- USER MENU -->
        <li class="nav-item dropdown position-relative">
            <a class="nav-link d-flex align-items-center" href="#" id="userDropdown"
                onclick="toggleUserMenu(event)">

                <img class="rounded-circle" src="{{ asset('assets/admin/img/boy.png') }}" width="40" height="40"
                    style="object-fit:cover;">

                <span class="ml-2 d-none d-lg-inline text-white small">
                    {{ auth()->user()->name ?? 'Admin' }}
                </span>
            </a>

            <div id="userMenu" class="dropdown-menu dropdown-menu-right shadow animated--grow-in">

                <a class="dropdown-item" href="{{ route('admin.user.index') }}">
                    <i class="fas fa-user mr-2 text-gray-400"></i> Data User
                </a>

                <a class="dropdown-item" href="{{ route('admin.laporan-keuangan.index') }}">
                    <i class="fas fa-list mr-2 text-gray-400"></i> Laporan Keuangan
                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="{{ route('admin.logout') }}" data-toggle="modal"
                    data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt mr-2 text-gray-400"></i> Logout
                </a>
            </div>
        </li>


    </ul>
</nav>
<!-- End Topbar -->
