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
                                        <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <!-- Cloud/flower outline shape with red border -->
                                            <path d="M25 8 C28 8, 31 9, 33 11 C35 13, 36 16, 36 19 C38 20, 39 22, 39 25 C39 28, 38 30, 36 31 C36 34, 35 37, 33 39 C31 41, 28 42, 25 42 C22 42, 19 41, 17 39 C15 37, 14 34, 14 31 C12 30, 11 28, 11 25 C11 22, 12 20, 14 19 C14 16, 15 13, 17 11 C19 9, 22 8, 25 8 Z" stroke="#DC143C" stroke-width="2.5" fill="#FFFFFF"/>
                                            <!-- Red cross -->
                                            <rect x="23" y="18" width="4" height="14" fill="#DC143C" rx="0.5"/>
                                            <rect x="18" y="23" width="14" height="4" fill="#DC143C" rx="0.5"/>
                                        </svg>
                                    </div>
                                    <div class="logo-text">
                                        <div class="text-line">Palang</div>
                                        <div class="text-line">Merah</div>
                                        <div class="text-line">Indonesia</div>
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
                                    <a href="{{ route('home') }}#home" class="{{ request()->routeIs('home') ? 'page-scroll' : '' }} {{ request()->routeIs('home') ? 'active' : '' }}"
                                        aria-label="Toggle navigation">Beranda</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ request()->routeIs('home') ? '#pendonasi' : route('home') . '#pendonasi' }}" class="{{ request()->routeIs('home') ? 'page-scroll' : '' }}"
                                        aria-label="Toggle navigation">Pendonasi</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ request()->routeIs('home') ? '#berita' : route('frontend.berita') }}" class="{{ request()->routeIs('home') ? 'page-scroll' : '' }} {{ request()->routeIs('frontend.berita*') ? 'active' : '' }}"
                                        aria-label="Toggle navigation">Berita</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ request()->routeIs('home') ? '#gallery' : route('frontend.gallery') }}" class="{{ request()->routeIs('home') ? 'page-scroll' : '' }} {{ request()->routeIs('frontend.gallery') ? 'active' : '' }}"
                                        aria-label="Toggle navigation">Gallery</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ request()->routeIs('home') ? '#about' : route('home') . '#about' }}" class="{{ request()->routeIs('home') ? 'page-scroll' : '' }}"
                                        aria-label="Toggle navigation">Tentang</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('donasi.create') }}"
                                        aria-label="Toggle navigation">Donasi</a>
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

