<!DOCTYPE html>
<html class="no-js" lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>@yield('title', 'Donasi PMI')</title>
    <meta name="description" content="@yield('description', 'Sistem Donasi PMI')" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/icon-pmi.jpeg') }}" />
    <link rel="alternate icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/LineIcons.2.0.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/tiny-slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/glightbox.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/pmi-custom.css') }}" />

    <style>
        /* PMI Logo Styles */
        .pmi-logo {
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .pmi-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .pmi-icon svg {
            width: 50px;
            height: 50px;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .logo-text .text-line {
            color: #000;
            font-size: 16px;
            font-weight: 600;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .logo-divider {
            width: 3px;
            height: 50px;
            background-color: #DC143C;
            flex-shrink: 0;
        }

        .logo-right {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .logo-right .text-line {
            font-size: 16px;
            font-weight: 600;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .logo-right .red-text {
            color: #DC143C;
        }

        .logo-right .italic-text {
            color: #000;
            font-style: italic;
            font-weight: 400;
            font-size: 14px;
        }

        /* Sticky header logo adjustment */
        .header.sticky .pmi-logo .logo-text .text-line,
        .header.sticky .pmi-logo .logo-right .red-text,
        .header.sticky .pmi-logo .logo-right .italic-text {
            color: #000;
        }

        .header.sticky .pmi-logo .logo-divider {
            background-color: #DC143C;
        }

        .header.sticky .pmi-icon {
            color: #DC143C;
        }

        /* Header default style - White background */
        .header {
            background-color: #fff !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .header .pmi-logo .logo-text .text-line {
            color: #000 !important;
        }

        .header .pmi-logo .logo-right .red-text {
            color: #DC143C !important;
        }

        .header .pmi-logo .logo-right .italic-text {
            color: #000 !important;
        }

        .header .pmi-logo .logo-divider {
            background-color: #DC143C !important;
        }

        .header .pmi-icon {
            color: #DC143C !important;
        }

        .header #nav .nav-item a {
            color: #333 !important;
        }

        .header #nav .nav-item a:hover,
        .header #nav .nav-item a.active {
            color: #DC143C !important;
        }

        .header .btn {
            background-color: #DC143C;
            color: #fff;
        }

        .header .btn:hover {
            background-color: #b01030;
        }

        /* Sticky header style - Red background (when scrolled) */
        .header.sticky {
            background-color: #DC143C !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .header.sticky .pmi-logo .logo-text .text-line {
            color: #fff !important;
        }

        .header.sticky .pmi-logo .logo-right .red-text {
            color: #fff !important;
        }

        .header.sticky .pmi-logo .logo-right .italic-text {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .header.sticky .pmi-logo .logo-divider {
            background-color: #fff !important;
        }

        .header.sticky .pmi-icon {
            color: #fff !important;
        }

        .header.sticky #nav .nav-item a {
            color: #fff !important;
        }

        .header.sticky #nav .nav-item a:hover,
        .header.sticky #nav .nav-item a.active {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .header.sticky .btn {
            background-color: #fff;
            color: #DC143C;
        }

        .header.sticky .btn:hover {
            background-color: rgba(255, 255, 255, 0.9);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .logo-container {
                gap: 10px;
            }

            .pmi-icon svg {
                width: 40px;
                height: 40px;
            }

            .logo-text .text-line,
            .logo-right .text-line {
                font-size: 14px;
            }

            .logo-right .italic-text {
                font-size: 12px;
            }

            .logo-divider {
                height: 40px;
            }
        }

        @media (max-width: 767px) {
            .logo-container {
                gap: 8px;
            }

            .pmi-icon svg {
                width: 35px;
                height: 35px;
            }

            .logo-text .text-line,
            .logo-right .text-line {
                font-size: 12px;
            }

            .logo-right .italic-text {
                font-size: 11px;
            }

            .logo-divider {
                height: 35px;
                width: 2px;
            }

            .logo-left {
                gap: 8px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->

    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- /End Preloader -->

    @include('frontend.partials.header')

    @yield('content')

    @include('frontend.partials.footer')

    <!-- ========================= scroll-top ========================= -->
    <a href="#" class="scroll-top">
        <i class="lni lni-chevron-up"></i>
    </a>

    <!-- ========================= JS here ========================= -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/tiny-slider.js') }}"></script>
    <script src="{{ asset('assets/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/count-up.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        // Force hide preloader after page load (fallback)
        function hidePreloader() {
            const preloader = document.querySelector('.preloader');
            if (preloader) {
                preloader.style.opacity = '0';
                preloader.style.display = 'none';
                preloader.style.transition = 'opacity 0.5s ease';
            }
        }

        // Hide preloader on DOMContentLoaded (faster)
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(hidePreloader, 500);

            const header = document.querySelector('.header');
            if (header && window.scrollY > 50) {
                header.classList.add('sticky');
            }
        });

        // Fallback: hide preloader after window load
        window.addEventListener('load', function() {
            setTimeout(hidePreloader, 1000);
        });

        // Final fallback: force hide after 2 seconds
        setTimeout(hidePreloader, 2000);

        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (header) {
                if (window.scrollY > 50) {
                    header.classList.add('sticky');
                } else {
                    header.classList.remove('sticky');
                }
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
