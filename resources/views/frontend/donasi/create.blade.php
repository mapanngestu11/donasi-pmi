@extends('frontend.layout')

@section('title', 'Form Donasi - Donasi PMI')

@section('content')
<!-- Start Hero Area -->
<section class="donasi-hero-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center">
                    <h2 class="donasi-title">Form Donasi</h2>
                    <p class="donasi-subtitle">Isi form di bawah ini untuk melakukan donasi</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Hero Area -->

<!-- Start Donation Form -->
<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> Terdapat kesalahan dalam form:
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('donasi.store') }}" method="POST" id="donasiForm">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                           id="nama" name="nama" value="{{ old('nama') }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="telepon" class="form-label">No. Telepon</label>
                                <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                                       id="telepon" name="telepon" value="{{ old('telepon') }}">
                                @error('telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah Donasi (Rp) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                                       id="jumlah" name="jumlah" value="{{ old('jumlah', $jumlah) }}" 
                                       min="10000" step="1000" required>
                                <small class="form-text text-muted">Minimum donasi: Rp 10.000</small>
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="pesan" class="form-label">Pesan (Opsional)</label>
                                <textarea class="form-control @error('pesan') is-invalid @enderror" 
                                          id="pesan" name="pesan" rows="3" 
                                          placeholder="Tuliskan pesan atau doa Anda...">{{ old('pesan') }}</textarea>
                                @error('pesan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="lni lni-heart"></i> Lanjutkan ke Pembayaran
                                </button>
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                    <i class="lni lni-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Donation Form -->

@push('styles')
<style>
    /* Hero Area dengan Background Merah */
    .donasi-hero-area {
        background: linear-gradient(135deg, #DC143C 0%, #B71C1C 100%);
        padding: 100px 0 60px;
        margin-bottom: 0;
    }
    
    .donasi-title {
        color: #ffffff !important;
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 15px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }
    
    .donasi-subtitle {
        color: #ffffff !important;
        font-size: 18px;
        font-weight: 400;
        opacity: 0.95;
        margin-bottom: 0;
    }
    
    /* Form Card Style */
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin-top: -30px;
        position: relative;
        z-index: 1;
    }
    
    .card-body {
        background: #ffffff;
    }
    
    /* Form Label Style */
    .form-label {
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
        font-size: 14px;
    }
    
    /* Form Control Style */
    .form-control, .form-select {
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
        font-size: 14px;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #DC143C;
        box-shadow: 0 0 0 0.2rem rgba(220, 20, 60, 0.25);
        outline: none;
    }
    
    /* Button Primary Style - PMI Red */
    .btn-primary {
        background: linear-gradient(135deg, #DC143C 0%, #B71C1C 100%);
        border: none;
        border-radius: 8px;
        padding: 15px 30px;
        font-weight: 600;
        font-size: 16px;
        color: #ffffff;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #B71C1C 0%, #8B0000 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(220, 20, 60, 0.4);
        color: #ffffff;
    }
    
    .btn-primary:active {
        transform: translateY(0);
    }
    
    /* Button Outline Secondary */
    .btn-outline-secondary {
        border: 2px solid #6c757d;
        border-radius: 8px;
        padding: 15px 30px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-outline-secondary:hover {
        background-color: #6c757d;
        border-color: #6c757d;
        color: #ffffff;
        transform: translateY(-2px);
    }
    
    /* Alert Style */
    .alert {
        border-radius: 8px;
        border: none;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    /* Text Muted */
    .text-muted {
        color: #6c757d !important;
        font-size: 13px;
    }
    
    /* Required Asterisk */
    .text-danger {
        color: #DC143C !important;
    }
    
    /* Invalid Feedback */
    .invalid-feedback {
        color: #DC143C;
        font-size: 13px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .donasi-hero-area {
            padding: 80px 0 50px;
        }
        
        .donasi-title {
            font-size: 36px;
        }
        
        .donasi-subtitle {
            font-size: 16px;
        }
        
        .card {
            margin-top: -20px;
        }
        
        .card-body {
            padding: 2rem !important;
        }
    }
    
    @media (max-width: 480px) {
        .donasi-title {
            font-size: 28px;
        }
        
        .donasi-subtitle {
            font-size: 14px;
        }
        
        .card-body {
            padding: 1.5rem !important;
        }
    }
</style>
@endpush
@endsection

