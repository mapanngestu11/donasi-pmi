<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="{{ asset('assets/images/icon-pmi.jpeg') }}" rel="icon" type="image/svg+xml">
    <link href="{{ asset('favicon.ico') }}" rel="alternate icon" type="image/x-icon">
    <title>Admin Login - Donasi PMI</title>
    <link href="{{ asset('assets/admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/css/ruang-admin.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/pmi-custom.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-login">
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <div style="margin-bottom: 20px;">
                                            <img src="{{ asset('assets/images/logo-pmi.jpeg') }}" alt="PMI Logo"
                                                style="margin-top:-10px; margin-bottom:-10px" width="200px">
                                        </div>
                                        {{-- <h1 class="h4 text-gray-900 mb-2">Palang Merah Indonesia</h1> --}}
                                        <h4 class="h5 text-gray-600 mb-4">Silahkan Login Terlebih Dahulu</h4>
                                    </div>

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <form class="user" method="POST" action="{{ route('admin.login.submit') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Masukkan Email" value="{{ old('email') }}" required
                                                autofocus>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="exampleInputPassword" placeholder="Password" required>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small"
                                                style="line-height: 1.5rem;">
                                                <input type="checkbox" class="custom-control-input" id="customCheck"
                                                    name="remember">
                                                <label class="custom-control-label" for="customCheck">Ingat Saya</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                                        </div>
                                        <hr>
                                    </form>
                                    <div class="text-center mt-3">
                                        <a class="small" href="{{ route('home') }}">Kembali ke Halaman Utama</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Content -->
    <script src="{{ asset('assets/admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/ruang-admin.min.js') }}"></script>
</body>

</html>
