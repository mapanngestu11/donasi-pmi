<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('assets/images/logo-pmi.jpeg') }}" alt="PMI Logo"
                style="margin-top:-10px; margin-bottom:-10px" width="200px" height="100px">
        </div>
        {{-- <div class="sidebar-brand-text mx-3">Admin</div> --}}
    </a>
    <hr class="sidebar-divider my-0">
    @php
        $user = auth()->user();
    @endphp

    <?php
    $cek = auth()->user()->hak_aksis;
    ?>
    @if (auth()->user()->hak_aksis === 'superadmin')
        <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <!-- Menu untuk Superadmin -->
        <li class="nav-item {{ request()->routeIs('admin.donasi.*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDonasi"
                aria-expanded="true" aria-controls="collapseDonasi">
                <i class="fas fa-fw fa-hand-holding-heart"></i>
                <span>Laporan Donasi</span>
            </a>
            <div id="collapseDonasi" class="collapse {{ request()->routeIs('admin.donasi.*') ? 'show' : '' }}"
                aria-labelledby="headingDonasi" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Laporan</h6>
                    <a class="collapse-item {{ request()->routeIs('admin.donasi.laporan') ? 'active' : '' }}"
                        href="{{ route('admin.donasi.laporan') }}">Pemasukan</a>
                    <a class="collapse-item {{ request()->routeIs('admin.donasi.pengeluaran*') ? 'active' : '' }}"
                        href="{{ route('admin.donasi.pengeluaran.index') }}">Pengeluaran</a>
                </div>
            </div>
        </li>

        <li class="nav-item {{ request()->routeIs('admin.laporan-keuangan.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.laporan-keuangan.index') }}">
                <i class="fas fa-fw fa-chart-line"></i>
                <span>Laporan Keuangan</span>
            </a>
        </li>
    @else
        <!-- Menu untuk admin selain superadmin -->
        <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('admin.donasi.*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDonasi"
                aria-expanded="true" aria-controls="collapseDonasi">
                <i class="fas fa-fw fa-hand-holding-heart"></i>
                <span>Laporan Donasi</span>
            </a>
            <div id="collapseDonasi" class="collapse {{ request()->routeIs('admin.donasi.*') ? 'show' : '' }}"
                aria-labelledby="headingDonasi" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Laporan</h6>
                    <a class="collapse-item {{ request()->routeIs('admin.donasi.laporan') ? 'active' : '' }}"
                        href="{{ route('admin.donasi.laporan') }}">Pemasukan</a>
                    <a class="collapse-item {{ request()->routeIs('admin.donasi.pengeluaran*') ? 'active' : '' }}"
                        href="{{ route('admin.donasi.pengeluaran.index') }}">Pengeluaran</a>
                </div>
            </div>
        </li>

        <li class="nav-item {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBerita"
                aria-expanded="true" aria-controls="collapseBerita">
                <i class="fas fa-fw fa-newspaper"></i>
                <span>Berita</span>
            </a>
            <div id="collapseBerita" class="collapse {{ request()->routeIs('admin.berita.*') ? 'show' : '' }}"
                aria-labelledby="headingBerita" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Berita</h6>
                    <a class="collapse-item {{ request()->routeIs('admin.berita.create') ? 'active' : '' }}"
                        href="{{ route('admin.berita.create') }}">
                        <i class="fas fa-plus"></i> Tambah Berita
                    </a>
                    <a class="collapse-item {{ request()->routeIs('admin.berita.index') && !request()->routeIs('admin.berita.create') && !request()->routeIs('admin.berita.kategori.*') ? 'active' : '' }}"
                        href="{{ route('admin.berita.index') }}">
                        <i class="fas fa-list"></i> List Berita
                    </a>
                    <a class="collapse-item {{ request()->routeIs('admin.berita.kategori.*') ? 'active' : '' }}"
                        href="{{ route('admin.berita.kategori.index') }}">
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
    @endif

    <hr class="sidebar-divider">
    <div class="version" id="version-ruangadmin"></div>
</ul>
<!-- Sidebar -->
