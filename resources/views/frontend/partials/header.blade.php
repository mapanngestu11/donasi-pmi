<!-- Start Header Area -->
<header class="header navbar-area">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="nav-inner">
                    <!-- Start Navbar -->
                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand pmi-logo" href="{{ route('home') }}">
                            <div class="logo-container">
                                <div class="logo-left">
                                    <div class="pmi-icon">
                                        <img src="{{ asset('assets/images/logo-pmi.jpeg') }}" alt="PMI Logo"
                                            style="margin-top:-10px; margin-bottom:-10px" width="50px" height="92px">
                                    </div>

                                </div>
                                <div class="logo-divider"></div>
                                <div class="logo-right">
                                    <div class="text-line red-text">Kota</div>
                                    <div class="text-line red-text">Tangerang</div>
                                    <div class="text-line italic-text">Move For Humanity</div>
                                </div>
                            </div>
                        </a>
                        <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                            <ul id="nav" class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a href="{{ route('home') }}#home"
                                        class="{{ request()->routeIs('home') ? 'page-scroll' : '' }} {{ request()->routeIs('home') ? 'active' : '' }}"
                                        aria-label="Toggle navigation">Beranda</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ request()->routeIs('home') ? '#pendonasi' : route('home') . '#pendonasi' }}"
                                        class="{{ request()->routeIs('home') ? 'page-scroll' : '' }}"
                                        aria-label="Toggle navigation">Pendonasi</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ request()->routeIs('home') ? '#berita' : route('frontend.berita') }}"
                                        class="{{ request()->routeIs('home') ? 'page-scroll' : '' }} {{ request()->routeIs('frontend.berita*') ? 'active' : '' }}"
                                        aria-label="Toggle navigation">Berita</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ request()->routeIs('home') ? '#gallery' : route('frontend.gallery') }}"
                                        class="{{ request()->routeIs('home') ? 'page-scroll' : '' }} {{ request()->routeIs('frontend.gallery') ? 'active' : '' }}"
                                        aria-label="Toggle navigation">Gallery</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ request()->routeIs('home') ? '#about' : route('home') . '#about' }}"
                                        class="{{ request()->routeIs('home') ? 'page-scroll' : '' }}"
                                        aria-label="Toggle navigation">Laporan</a>
                                </li>

                            </ul>
                        </div> <!-- navbar collapse -->
                        <div class="button add-list-button">
                            <a href="{{ route('donasi.create') }}" class="btn">Donasi Sekarang</a>
                        </div>
                    </nav>
                    <!-- End Navbar -->
                </div>
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</header>
<!-- End Header Area -->
