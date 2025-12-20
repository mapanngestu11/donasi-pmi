@extends('frontend.layout')

@section('title', 'Beranda - Donasi PMI')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
<!-- Start Hero Area -->
<section id="home" class="hero-area">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-12 col-12">
                <div class="hero-content">
                    <h1 class="wow fadeInLeft" data-wow-delay=".4s">Sistem Donasi PMI untuk Kemanusiaan.</h1>
                    <p class="wow fadeInLeft" data-wow-delay=".6s">Bersama Palang Merah Indonesia, mari wujudkan kepedulian kita untuk membantu sesama yang membutuhkan melalui donasi online yang mudah dan terpercaya.</p>
                    <div class="button wow fadeInLeft" data-wow-delay=".8s">
                        <a href="{{ route('donasi.create') }}" class="btn"><i class="lni lni-heart"></i> Donasi Sekarang</a>
                        <a href="#about" class="btn btn-alt"><i class="lni lni-information"></i> Pelajari Lebih Lanjut</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-12 col-12">
                <div class="hero-image wow fadeInRight" data-wow-delay=".4s">
                    <img src="{{ asset('assets/images/hero/phone.png') }}" alt="#">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Hero Area -->

<!-- Start Pendonasi Terbaru Area -->
<section id="pendonasi" class="section" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h3 class="wow zoomIn" data-wow-delay=".2s">Pendonasi</h3>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Pendonasi Terbaru</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Terima kasih kepada para pendonasi yang telah berpartisipasi dalam program kemanusiaan PMI.</p>
                </div>
            </div>
        </div>
        <div class="row">
            @forelse($pendonasi as $donasi)
            <div class="col-lg-4 col-md-6 col-12 mb-4">
                <div class="single-pendonasi-card wow fadeInUp" data-wow-delay=".{{ $loop->iteration * 2 }}s">
                    <div class="pendonasi-card-header">
                        <div class="pendonasi-avatar">
                            <i class="lni lni-user"></i>
                        </div>
                        <div class="pendonasi-info">
                            <h5 class="pendonasi-name">{{ $donasi->nama }}</h5>
                            <span class="pendonasi-time">
                                <i class="lni lni-calendar"></i>
                                {{ $donasi->settlement_time ? $donasi->settlement_time->format('d M Y') : $donasi->created_at->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="pendonasi-card-body">
                        @php
                            // Ambil pesan langsung dari property
                            $pesan = $donasi->pesan ?? '';
                            if (empty(trim($pesan))) {
                                $pesan = $donasi->keterangan_pesan ?? '';
                            }
                            $pesan = trim($pesan);
                        @endphp
                        @if($pesan != '')
                        <div class="pendonasi-message">
                            <i class="lni lni-quotation"></i>
                            <p style="color: #000 !important; font-weight: 500 !important; margin: 0;">{{ $pesan }}</p>
                        </div>
                        @endif
                        <div class="pendonasi-details">
                            @if($donasi->bank_display && $donasi->bank_display != '-')
                            <div class="pendonasi-bank">
                                <i class="lni lni-credit-cards"></i>
                                <span>{{ $donasi->bank_display }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="pendonasi-card-footer">
                        <div class="pendonasi-amount blurred">
                            <i class="lni lni-heart"></i>
                            <span>Rp {{ number_format($donasi->jumlah, 0, ',', '.') }}</span>
                        </div>
                        <div class="pendonasi-status">
                            <span class="badge badge-success">Berhasil</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="lni lni-heart" style="font-size: 60px; color: #ccc; margin-bottom: 20px;"></i>
                    <p class="text-muted" style="font-size: 16px;">Belum ada pendonasi yang terdaftar.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>
<!-- End Pendonasi Terbaru Area -->

<!-- Start Berita Area -->
<section id="berita" class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h3 class="wow zoomIn" data-wow-delay=".2s">Berita</h3>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Berita Terbaru</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Ikuti update terbaru dari kegiatan dan program PMI.</p>
                </div>
            </div>
        </div>
        <div class="berita-scroll-wrapper">
            <div class="berita-scroll-container">
                @forelse($beritas as $berita)
                <div class="berita-scroll-item">
                    <div class="single-berita wow fadeInUp" data-wow-delay=".{{ $loop->iteration * 2 }}s">
                        <div class="berita-image">
                            <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}" onerror="this.src='{{ asset('assets/images/hero/phone.png') }}'">
                            @if($berita->kategori)
                                <div class="berita-category">
                                    <span>{{ $berita->kategori->nama }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="berita-content">
                            <div class="berita-meta">
                                <span><i class="lni lni-calendar"></i> {{ $berita->published_at ? $berita->published_at->format('d M Y') : $berita->created_at->format('d M Y') }}</span>
                                @if($berita->penulis)
                                    <span><i class="lni lni-user"></i> {{ $berita->penulis }}</span>
                                @endif
                            </div>
                            <h4 class="berita-title">
                                <a href="{{ route('frontend.berita.detail', $berita->slug) }}">{{ $berita->judul }}</a>
                            </h4>
                            <p class="berita-excerpt">
                                {{ Str::limit($berita->ringkasan ? $berita->ringkasan : strip_tags($berita->konten), 120) }}
                            </p>
                            <a href="{{ route('frontend.berita.detail', $berita->slug) }}" class="berita-link">Baca Selengkapnya <i class="lni lni-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="berita-scroll-item" style="width: 100%;">
                    <div class="text-center py-5">
                        <i class="lni lni-file" style="font-size: 60px; color: #ccc; margin-bottom: 20px;"></i>
                        <p class="text-muted" style="font-size: 16px;">Belum ada berita yang dipublikasikan.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
        @if($beritas && $beritas->count() > 0)
        <div class="row">
            <div class="col-12 text-center mt-4">
                <a href="{{ route('frontend.berita') }}" class="btn btn-primary">Lihat Semua Berita</a>
            </div>
        </div>
        @endif
    </div>
</section>
<!-- End Berita Area -->

<!-- Start Gallery Area -->
<section id="gallery" class="section" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h3 class="wow zoomIn" data-wow-delay=".2s">Gallery</h3>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Gallery Kegiatan</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Lihat dokumentasi kegiatan dan program PMI.</p>
                </div>
            </div>
        </div>
        <div class="row">
            @forelse($galleries as $gallery)
            <div class="col-lg-3 col-md-4 col-6">
                <div class="single-gallery wow fadeInUp" data-wow-delay=".{{ $loop->iteration * 2 }}s">
                    <div class="gallery-image">
                        @if($gallery->gambar)
                            <a href="javascript:void(0)" 
                               class="gallery-modal-trigger" 
                               data-image="{{ $gallery->gambar_url }}"
                               data-title="{{ $gallery->judul_kegiatan }}"
                               data-description="{{ $gallery->deskripsi }}"
                               data-date="{{ $gallery->tanggal ? $gallery->tanggal->format('d M Y') : $gallery->created_at->format('d M Y') }}">
                                <img src="{{ $gallery->gambar_url }}" alt="{{ $gallery->judul_kegiatan }}">
                            </a>
                        @else
                            <img src="{{ asset('assets/images/hero/phone.png') }}" alt="{{ $gallery->judul_kegiatan }}">
                        @endif
                        <div class="gallery-overlay">
                            <div class="gallery-content">
                                <h5>{{ $gallery->judul_kegiatan }}</h5>
                                @if($gallery->deskripsi)
                                    <p>{{ Str::limit($gallery->deskripsi, 60) }}</p>
                                @endif
                                @if($gallery->tanggal)
                                    <span class="gallery-date"><i class="lni lni-calendar"></i> {{ $gallery->tanggal->format('d M Y') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="lni lni-image" style="font-size: 60px; color: #ccc; margin-bottom: 20px;"></i>
                    <p class="text-muted" style="font-size: 16px;">Belum ada gambar di gallery.</p>
                </div>
            </div>
            @endforelse
        </div>
        @if($galleries && $galleries->count() > 0)
        <div class="row">
            <div class="col-12 text-center mt-4">
                <a href="{{ route('frontend.gallery') }}" class="btn btn-primary">Lihat Semua Gallery</a>
            </div>
        </div>
        @endif
    </div>
</section>
<!-- End Gallery Area -->

<!-- Start About/Laporan Keuangan Area -->
<section id="about" class="section call-action" style="background: linear-gradient(135deg, #DC143C 0%, #B71C1C 100%); padding: 80px 0;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center mb-5">
                    <h2 class="wow fadeInUp" data-wow-delay=".2s" style="color: #fff; font-size: 36px; font-weight: 700; margin-bottom: 15px;">Laporan Keuangan</h2>
                    <p class="wow fadeInUp" data-wow-delay=".4s" style="color: rgba(255,255,255,0.9); font-size: 16px; margin: 0;">
                        Transparansi pemasukan dan pengeluaran donasi PMI
                    </p>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-10 offset-lg-1 col-12">
                <div class="card shadow-lg financial-report-card">
                    <div class="card-header financial-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <ul class="nav nav-tabs card-header-tabs" id="financialTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="pemasukan-tab" data-toggle="tab" href="#pemasukan" 
                                        role="tab" aria-controls="pemasukan" aria-selected="true">
                                        <i class="fas fa-arrow-down"></i> Pemasukan
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pengeluaran-tab" data-toggle="tab" href="#pengeluaran" 
                                        role="tab" aria-controls="pengeluaran" aria-selected="false">
                                        <i class="fas fa-arrow-up"></i> Pengeluaran
                                    </a>
                                </li>
                            </ul>
                            <div class="download-buttons">
                                <button type="button" class="btn btn-download btn-excel" onclick="exportToExcel()" title="Download Excel">
                                    <i class="fas fa-file-excel"></i> Excel
                                </button>
                                <button type="button" class="btn btn-download btn-pdf" onclick="exportToPDF()" title="Download PDF">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body financial-body">
                        <div class="tab-content" id="financialTabsContent">
                            <!-- Tab Pemasukan -->
                            <div class="tab-pane fade show active" id="pemasukan" role="tabpanel" aria-labelledby="pemasukan-tab">
                                <div class="table-responsive">
                                    <table class="table financial-table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Jumlah Donasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pemasukan ?? [] as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    {{ $item->settlement_time ? $item->settlement_time->format('d M Y') : ($item->created_at ? $item->created_at->format('d M Y') : '-') }}
                                                </td>
                                                <td class="amount-success">
                                                    Rp {{ number_format($item->jumlah ?? 0, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3" class="empty-state">
                                                    <i class="fas fa-inbox"></i>
                                                    <p>Belum ada data pemasukan</p>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                        @if(isset($pemasukan) && $pemasukan->count() > 0)
                                        <tfoot>
                                            <tr class="subtotal-row">
                                                <td colspan="2" class="text-right font-weight-bold">Sub Total:</td>
                                                <td class="amount-success font-weight-bold">
                                                    Rp {{ number_format($subtotalPemasukan ?? 0, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                        @endif
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Tab Pengeluaran -->
                            <div class="tab-pane fade" id="pengeluaran" role="tabpanel" aria-labelledby="pengeluaran-tab" style="display: none;">
                                <div class="table-responsive">
                                    <table class="table financial-table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Jenis</th>
                                                <th>Tanggal</th>
                                                <th>Keterangan</th>
                                                <th>Detail</th>
                                                <th>Nama/Penanggung Jawab</th>
                                                <th>Bank</th>
                                                <th>Nominal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pengeluaran ?? [] as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <span class="badge badge-danger">Pengeluaran</span>
                                                </td>
                                                <td>
                                                    {{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-' }}
                                                </td>
                                                <td>{{ $item->nama_kegiatan ?? '-' }}</td>
                                                <td>{{ Str::limit($item->rincian ?? '-', 50) }}</td>
                                                <td>{{ $item->penanggung_jawab ?? '-' }}</td>
                                                <td>-</td>
                                                <td class="amount-danger">
                                                    Rp {{ number_format($item->besar_anggaran ?? 0, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="8" class="empty-state">
                                                    <i class="fas fa-inbox"></i>
                                                    <p>Belum ada data pengeluaran</p>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End About/Laporan Keuangan Area -->

@push('styles')
<style>
    /* Pendonasi Card Styles */
    .single-pendonasi-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    
    .single-pendonasi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    
    .pendonasi-card-header {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        background: linear-gradient(135deg, #DC143C 0%, #B71C1C 100%);
        color: #fff;
    }
    
    .pendonasi-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #fff;
        flex-shrink: 0;
    }
    
    .pendonasi-info {
        flex: 1;
    }
    
    .pendonasi-info .pendonasi-name {
        font-size: 18px;
        font-weight: 600;
        color: #fff;
        margin: 0 0 5px 0;
    }
    
    .pendonasi-info .pendonasi-time {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.9);
    }
    
    .pendonasi-info .pendonasi-time i {
        font-size: 14px;
    }
    
    .pendonasi-card-body {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .pendonasi-message {
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #DC143C;
        margin-bottom: 15px;
    }
    
    .pendonasi-message i {
        color: #DC143C;
        font-size: 18px;
        margin-right: 8px;
    }
    
    .pendonasi-message p {
        margin: 0;
        color: #000;
        font-style: italic;
        line-height: 1.6;
        font-weight: 500;
    }
    
    .pendonasi-details {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .pendonasi-program,
    .pendonasi-bank {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        background: #f0f7ff;
        border-radius: 6px;
        color: #DC143C;
        font-size: 13px;
        font-weight: 500;
    }
    
    .pendonasi-program i,
    .pendonasi-bank i {
        font-size: 14px;
    }
    
    .pendonasi-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: #f8f9fa;
        border-top: 1px solid #e0e0e0;
    }
    
    .pendonasi-amount {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 20px;
        font-weight: 700;
    }
    
    .pendonasi-amount i {
        color: #DC143C;
        font-size: 22px;
    }
    
    .pendonasi-amount span {
        color: #DC143C;
    }
    
    .pendonasi-status .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .badge-success {
        background-color: #28a745;
        color: #fff;
    }
    
    /* Blur Effect */
    .blurred {
        position: relative;
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }
    
    .blurred span {
        filter: blur(5px);
        -webkit-filter: blur(5px);
        -moz-filter: blur(5px);
        -ms-filter: blur(5px);
        transition: filter 0.3s ease;
    }
    
    .blurred::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, 
            rgba(255,255,255,0) 0%, 
            rgba(255,255,255,0.3) 50%, 
            rgba(255,255,255,0) 100%);
        pointer-events: none;
    }
    
    /* Responsive for Pendonasi Card */
    @media (max-width: 768px) {
        .pendonasi-card-header {
            padding: 15px;
        }
        
        .pendonasi-avatar {
            width: 40px;
            height: 40px;
            font-size: 20px;
        }
        
        .pendonasi-info .pendonasi-name {
            font-size: 16px;
        }
        
        .pendonasi-card-body {
            padding: 15px;
        }
        
        .pendonasi-card-footer {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .pendonasi-amount {
            font-size: 18px;
        }
    }

    /* Berita Styles */
    .single-berita {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .single-berita:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .berita-image {
        position: relative;
        overflow: hidden;
        height: 200px;
    }

    .berita-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .single-berita:hover .berita-image img {
        transform: scale(1.1);
    }

    .berita-category {
        position: absolute;
        top: 15px;
        right: 15px;
        background-color: #DC143C;
        color: #fff;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(220, 20, 60, 0.3);
    }

    .berita-content {
        padding: 25px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .berita-meta {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
        font-size: 13px;
        color: #666;
    }

    .berita-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .berita-meta i {
        color: #667eea;
    }

    .berita-title {
        margin-bottom: 12px;
        font-size: 20px;
        font-weight: 600;
        line-height: 1.4;
    }

    .berita-title a {
        color: #333;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .berita-title a:hover {
        color: #667eea;
    }

    .berita-excerpt {
        color: #666;
        line-height: 1.6;
        margin-bottom: 15px;
        flex: 1;
    }

    .berita-link {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: gap 0.3s ease;
    }

    .berita-link:hover {
        gap: 10px;
    }

    /* Gallery Styles */
    .single-gallery {
        margin-bottom: 30px;
    }

    .gallery-image {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        height: 250px;
        cursor: pointer;
    }

    .gallery-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .single-gallery:hover .gallery-image img {
        transform: scale(1.1);
    }

    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: flex-end;
        padding: 20px;
    }

    .single-gallery:hover .gallery-overlay {
        opacity: 1;
    }

    .gallery-content {
        color: #fff;
        width: 100%;
    }

    .gallery-content h5 {
        color: #fff;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .gallery-content p {
        color: rgba(255,255,255,0.9);
        font-size: 14px;
        margin-bottom: 8px;
        line-height: 1.5;
    }

    .gallery-date {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: rgba(255,255,255,0.8);
    }

    /* Berita Horizontal Scroll */
    .berita-scroll-wrapper {
        position: relative;
        width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        padding: 20px 0;
        margin: 20px 0;
    }

    .berita-scroll-wrapper::-webkit-scrollbar {
        height: 8px;
    }

    .berita-scroll-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .berita-scroll-wrapper::-webkit-scrollbar-thumb {
        background: #DC143C;
        border-radius: 10px;
    }

    .berita-scroll-wrapper::-webkit-scrollbar-thumb:hover {
        background: #B71C1C;
    }

    .berita-scroll-container {
        display: flex;
        gap: 30px;
        padding: 10px 0;
        min-width: min-content;
    }

    .berita-scroll-item {
        flex: 0 0 auto;
        width: 350px;
        min-width: 300px;
    }

    .berita-scroll-item .single-berita {
        height: 100%;
        margin: 0;
    }

    /* Responsive for Berita and Gallery */
    @media (max-width: 768px) {
        .berita-scroll-item {
            width: 280px;
            min-width: 250px;
        }

        .berita-image {
            height: 180px;
        }

        .berita-content {
            padding: 20px;
        }

        .berita-title {
            font-size: 18px;
        }

        .gallery-image {
            height: 200px;
        }

        .berita-scroll-container {
            gap: 20px;
        }
    }

    @media (max-width: 480px) {
        .berita-scroll-item {
            width: 250px;
            min-width: 220px;
        }

        .berita-scroll-container {
            gap: 15px;
        }
    }
    
    /* Modal Styles */
    #galleryModal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1050;
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        overflow-y: auto;
        outline: 0;
    }
    
    #galleryModal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    #galleryModal .modal-dialog {
        position: relative;
        width: auto;
        margin: 1.75rem auto;
        max-width: 900px;
        pointer-events: none;
    }
    
    #galleryModal.show .modal-dialog {
        pointer-events: auto;
    }
    
    #galleryModal .modal-content {
        position: relative;
        display: flex;
        flex-direction: column;
        width: 100%;
        pointer-events: auto;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid rgba(0,0,0,.2);
        border-radius: 10px;
        outline: 0;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }
    
    #galleryModal .modal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding: 1rem 1rem;
        border-bottom: 1px solid #e9ecef;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    
    #galleryModal .modal-title {
        margin-bottom: 0;
        line-height: 1.5;
        font-size: 20px;
        font-weight: 600;
        color: #333;
    }
    
    #galleryModal .close {
        padding: 1rem 1rem;
        margin: -1rem -1rem -1rem auto;
        background: transparent;
        border: 0;
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        opacity: .5;
        cursor: pointer;
    }
    
    #galleryModal .close:hover {
        opacity: 1;
    }
    
    #galleryModal .modal-body {
        position: relative;
        flex: 1 1 auto;
        padding: 1rem;
    }
    
    #modalGalleryImage {
        max-height: 70vh;
        width: auto;
        max-width: 100%;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .gallery-modal-info {
        text-align: left;
        margin-top: 1rem;
    }
    
    #modalGalleryDescription {
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 10px;
        color: #6c757d;
    }
    
    #modalGalleryDate {
        font-size: 13px;
        color: #6c757d;
    }
    
    .gallery-modal-trigger {
        cursor: pointer;
        display: block;
    }
    
    .gallery-modal-trigger:hover {
        text-decoration: none;
    }
    
    /* Modal Backdrop */
    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1040;
        width: 100vw;
        height: 100vh;
        background-color: #000;
    }
    
    .modal-backdrop.fade {
        opacity: 0;
        transition: opacity 0.15s linear;
    }
    
    .modal-backdrop.show {
        opacity: 0.5;
    }
    
    body.modal-open {
        overflow: hidden;
    }
    
    /* Laporan Keuangan Styles */
    #about {
        background: linear-gradient(135deg, #DC143C 0%, #B71C1C 100%) !important;
    }
    
    #about .section-title h2 {
        color: #fff !important;
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 15px;
    }
    
    #about .section-title p {
        color: rgba(255,255,255,0.9) !important;
        font-size: 16px;
    }
    
    .financial-report-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }
    
    .financial-header {
        background-color: #DC143C;
        border: none;
        padding: 0;
    }
    
    .financial-header .d-flex {
        align-items: stretch;
    }
    
    .financial-header .nav-tabs {
        border: none;
        flex: 1;
    }
    
    .financial-header .nav-tabs .nav-link {
        border: none;
        border-radius: 0;
        padding: 18px 30px;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 15px;
        color: #999;
        background: #fff;
        margin: 0;
    }
    
    .financial-header .nav-tabs .nav-link:hover {
        color: #DC143C;
        background-color: #fff;
    }
    
    .financial-header .nav-tabs .nav-link.active {
        color: #DC143C;
        background-color: #fff;
        border-bottom: 3px solid #DC143C;
        font-weight: 700;
    }
    
    .financial-header .nav-tabs .nav-link i {
        margin-right: 8px;
    }
    
    .download-buttons {
        display: flex;
        gap: 10px;
        padding: 10px 20px;
        align-items: center;
    }
    
    .btn-download {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #fff;
    }
    
    .btn-download i {
        font-size: 14px;
    }
    
    .btn-excel {
        background-color: #28a745;
    }
    
    .btn-excel:hover {
        background-color: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
    }
    
    .btn-pdf {
        background-color: #dc3545;
    }
    
    .btn-pdf:hover {
        background-color: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    }
    
    .financial-body {
        background-color: #fff;
        padding: 30px;
    }
    
    .financial-table {
        margin-bottom: 0;
        background-color: #fff;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .financial-table thead {
        background-color: #f8f9fa;
    }
    
    .financial-table thead th {
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #333;
        padding: 16px;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }
    
    .financial-table tbody td {
        padding: 16px;
        vertical-align: middle;
        color: #333;
        font-size: 14px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .financial-table tbody tr {
        transition: all 0.2s ease;
    }
    
    .financial-table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .financial-table tbody tr:last-child td {
        border-bottom: none;
    }
    
    .financial-table tfoot {
        background-color: #f8f9fa;
        border-top: 2px solid #dee2e6;
    }
    
    .financial-table tfoot .subtotal-row {
        background-color: #f8f9fa;
    }
    
    .financial-table tfoot td {
        padding: 16px;
        font-size: 15px;
    }
    
    /* Ensure tab panes are properly hidden/shown */
    #financialTabsContent .tab-pane {
        display: none;
    }
    
    #financialTabsContent .tab-pane.active {
        display: block;
    }
    
    #financialTabsContent .tab-pane.show {
        display: block;
    }
    
    .financial-table .amount-success {
        color: #28a745;
        font-weight: 700;
        font-size: 15px;
    }
    
    .financial-table .amount-danger {
        color: #dc3545;
        font-weight: 700;
        font-size: 15px;
    }
    
    .financial-table .badge {
        padding: 6px 12px;
        font-size: 11px;
        font-weight: 600;
        border-radius: 4px;
    }
    
    .financial-table .badge-success {
        background-color: #28a745;
        color: #fff;
    }
    
    .financial-table .badge-danger {
        background-color: #dc3545;
        color: #fff;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px !important;
        color: #999;
    }
    
    .empty-state i {
        font-size: 48px;
        opacity: 0.3;
        margin-bottom: 15px;
        color: #999;
        display: block;
    }
    
    .empty-state p {
        margin: 0;
        font-size: 15px;
        color: #999;
    }
    
    @media (max-width: 991px) {
        .download-buttons {
            flex-direction: column;
            gap: 8px;
            padding: 10px 15px;
        }
        
        .btn-download {
            width: 100%;
            justify-content: center;
        }
    }
    
    @media (max-width: 768px) {
        #about {
            padding: 60px 0 !important;
        }
        
        #about .section-title h2 {
            font-size: 28px;
        }
        
        .financial-header .nav-tabs .nav-link {
            padding: 15px 20px;
            font-size: 14px;
        }
        
        .financial-header .d-flex {
            flex-direction: column;
        }
        
        .download-buttons {
            width: 100%;
            padding: 15px;
            flex-direction: row;
            justify-content: center;
        }
        
        .financial-body {
            padding: 20px;
        }
        
        .financial-table {
            font-size: 13px;
        }
        
        .financial-table thead th,
        .financial-table tbody td {
            padding: 12px 8px;
        }
    }
</style>
@endpush


@push('scripts')
<script type="text/javascript">
    // Handle gallery image click to show modal
    (function() {
        'use strict';
        
        function initGalleryModal() {
            const galleryTriggers = document.querySelectorAll('.gallery-modal-trigger');
            const modal = document.getElementById('galleryModal');
            
            if (!modal) {
                console.error('Modal element not found');
                return;
            }
            
            const modalImage = document.getElementById('modalGalleryImage');
            const modalTitle = document.getElementById('galleryModalLabel');
            const modalDescription = document.getElementById('modalGalleryDescription');
            const modalDate = document.getElementById('modalGalleryDate');
            const closeBtn = modal.querySelector('.close');
            
            // Close modal function
            function closeModal() {
                modal.classList.remove('show');
                modal.style.display = 'none';
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.classList.remove('show');
                    setTimeout(function() {
                        if (backdrop && backdrop.parentNode) {
                            backdrop.parentNode.removeChild(backdrop);
                        }
                    }, 150);
                }
            }
            
            // Add click event to all gallery triggers
            galleryTriggers.forEach(function(trigger) {
                trigger.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const imageUrl = this.getAttribute('data-image');
                    const title = this.getAttribute('data-title');
                    const description = this.getAttribute('data-description');
                    const date = this.getAttribute('data-date');
                    
                    console.log('Gallery clicked:', {imageUrl, title, description, date});
                    
                    // Set modal content
                    if (modalTitle) modalTitle.textContent = title || '';
                    if (modalImage) {
                        modalImage.src = imageUrl || '';
                        modalImage.alt = title || 'Gallery Image';
                    }
                    if (modalDescription) modalDescription.textContent = description || '';
                    if (modalDate) modalDate.innerHTML = '<i class="lni lni-calendar"></i> ' + (date || '');
                    
                    // Show modal
                    modal.classList.add('show');
                    modal.style.display = 'flex';
                    document.body.classList.add('modal-open');
                    document.body.style.overflow = 'hidden';
                    
                    // Add backdrop
                    let backdrop = document.querySelector('.modal-backdrop');
                    if (!backdrop) {
                        backdrop = document.createElement('div');
                        backdrop.className = 'modal-backdrop fade';
                        document.body.appendChild(backdrop);
                        // Trigger fade in
                        setTimeout(function() {
                            backdrop.classList.add('show');
                        }, 10);
                    } else {
                        backdrop.classList.add('show');
                    }
                });
            });
            
            // Close button
            if (closeBtn) {
                closeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    closeModal();
                });
            }
            
            // Close on backdrop click
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
            
            // Close on ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.classList.contains('show')) {
                    closeModal();
                }
            });
        }
        
        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initGalleryModal);
        } else {
            initGalleryModal();
        }
    })();

    // Handle header button color on scroll
    window.addEventListener('scroll', function() {
        var header = document.querySelector('.header.navbar-area');
        var headerButton = document.querySelector('.add-list-button .btn');
        
        if (header && headerButton) {
            if (window.pageYOffset > 100) {
                header.classList.add('sticky');
            } else {
                header.classList.remove('sticky');
            }
        }
    });
    
    // Handle tab switching for financial report
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('#financialTabs .nav-link');
        const tabPanes = document.querySelectorAll('#financialTabsContent .tab-pane');
        
        function switchTab(clickedTab) {
            // Get target tab pane
            const targetId = clickedTab.getAttribute('href');
            const targetPane = document.querySelector(targetId);
            
            if (!targetPane) {
                console.error('Target pane not found:', targetId);
                return;
            }
            
            // Hide all tab panes with proper Bootstrap classes
            tabPanes.forEach(function(pane) {
                pane.classList.remove('show', 'active');
                pane.style.display = 'none';
            });
            
            // Show target tab pane
            targetPane.classList.add('show', 'active');
            targetPane.style.display = 'block';
            
            // Update active state styling for tabs
            tabs.forEach(function(t) {
                t.style.color = '#999';
                t.style.backgroundColor = '#fff';
                t.style.borderBottom = 'none';
                t.style.fontWeight = '600';
                t.classList.remove('active');
                t.setAttribute('aria-selected', 'false');
            });
            
            // Active tab: white background, red text, red border bottom
            clickedTab.style.color = '#DC143C';
            clickedTab.style.backgroundColor = '#fff';
            clickedTab.style.borderBottom = '3px solid #DC143C';
            clickedTab.style.fontWeight = '700';
            clickedTab.classList.add('active');
            clickedTab.setAttribute('aria-selected', 'true');
        }
        
        tabs.forEach(function(tab) {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                switchTab(this);
            });
        });
        
        // Initialize first tab (active)
        if (tabs.length > 0) {
            const activeTab = document.querySelector('#financialTabs .nav-link.active');
            if (activeTab) {
                activeTab.style.color = '#DC143C';
                activeTab.style.backgroundColor = '#fff';
                activeTab.style.borderBottom = '3px solid #DC143C';
                activeTab.style.fontWeight = '700';
                
                // Ensure active tab pane is visible
                const activePaneId = activeTab.getAttribute('href');
                const activePane = document.querySelector(activePaneId);
                if (activePane) {
                    activePane.classList.add('show', 'active');
                    activePane.style.display = 'block';
                }
            }
            
            // Set non-active tabs and hide their panes
            tabs.forEach(function(tab) {
                if (!tab.classList.contains('active')) {
                    tab.style.color = '#999';
                    tab.style.backgroundColor = '#fff';
                    
                    // Hide non-active panes
                    const paneId = tab.getAttribute('href');
                    const pane = document.querySelector(paneId);
                    if (pane) {
                        pane.classList.remove('show', 'active');
                        pane.style.display = 'none';
                    }
                }
            });
        }
    });
    
    // Export functions
    function exportToExcel() {
        const activeTab = document.querySelector('#financialTabs .nav-link.active');
        const type = activeTab && activeTab.id === 'pemasukan-tab' ? 'pemasukan' : 'pengeluaran';
        window.location.href = '{{ route("frontend.laporan.export") }}?type=' + type + '&format=excel';
    }
    
    function exportToPDF() {
        const activeTab = document.querySelector('#financialTabs .nav-link.active');
        const type = activeTab && activeTab.id === 'pemasukan-tab' ? 'pemasukan' : 'pengeluaran';
        window.location.href = '{{ route("frontend.laporan.export") }}?type=' + type + '&format=pdf';
    }
</script>
@endpush

<!-- Modal untuk Zoom Gambar -->
<div class="modal fade" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="galleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modalGalleryImage" src="" alt="Gallery Image" class="img-fluid">
                <div class="gallery-modal-info mt-3">
                    <p id="modalGalleryDescription" class="text-muted"></p>
                    <small id="modalGalleryDate" class="text-muted"></small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

