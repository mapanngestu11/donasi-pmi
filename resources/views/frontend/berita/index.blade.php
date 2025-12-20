@extends('frontend.layout')

@section('title', 'Berita - Donasi PMI')

@section('content')
<!-- Start Breadcrumbs -->
<section class="breadcrumbs" style="background: linear-gradient(135deg, #DC143C 0%, #B71C1C 100%); padding: 80px 0 60px; margin-top: 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-content text-center">
                    <h1 class="page-title" style="color: #fff; font-size: 3rem; font-weight: 700; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 2px;">Berita</h1>
                    <p style="color: rgba(255, 255, 255, 0.9); font-size: 1.1rem; margin: 0;">Informasi terkini dari Palang Merah Indonesia</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Breadcrumbs -->

<!-- Start Blog Area -->
<section class="blog-area blog-page section" style="padding: 60px 0; background-color: #f8f9fa;">
    <div class="container">
        <div class="row" style="margin-top: 0;">
            <!-- Sidebar -->
            <div class="col-lg-4 col-md-12 col-12" style="margin-bottom: 30px;">
                <div class="blog-sidebar" style="position: sticky; top: 20px;">
                    <!-- Search Widget -->
                    <div class="single-widget search">
                        <h3>Cari Berita</h3>
                        <form action="{{ route('frontend.berita') }}" method="GET">
                            <input type="text" name="search" placeholder="Cari berita..." value="{{ request('search') }}">
                            <button type="submit"><i class="lni lni-search-alt"></i></button>
                        </form>
                    </div>

                    <!-- Categories Widget -->
                    <div class="single-widget categories">
                        <h3>Kategori</h3>
                        <ul>
                            <li>
                                <a href="{{ route('frontend.berita') }}" class="{{ !request('kategori') ? 'active' : '' }}">
                                    Semua Kategori
                                </a>
                            </li>
                            @if(isset($kategoris) && $kategoris->count() > 0)
                                @foreach($kategoris as $kategori)
                                <li>
                                    <a href="{{ route('frontend.berita', ['kategori' => $kategori->id]) }}" 
                                       class="{{ request('kategori') == $kategori->id ? 'active' : '' }}">
                                        {{ $kategori->nama ?? 'Kategori' }}
                                    </a>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Blog Posts -->
            <div class="col-lg-8 col-md-12 col-12">
                <div class="row" style="margin: 0 -15px;">
                    @if(isset($beritas) && $beritas->count() > 0)
                        @foreach($beritas as $berita)
                        <div class="col-lg-6 col-md-6 col-12 mb-4">
                            <div class="single-blog" style="margin-bottom: 30px;">
                                <div class="blog-image-wrapper" style="position: relative; overflow: hidden; border-radius: 8px 8px 0 0; height: 220px; background: #f0f0f0;">
                                    <a href="{{ route('frontend.berita.detail', $berita->slug ?? '#') }}" style="display: block; width: 100%; height: 100%; position: relative;">
                                        @php
                                            $gambarUrl = $berita->gambar_url;
                                            $placeholderSvg = 'data:image/svg+xml;base64,' . base64_encode('
                                                <svg xmlns="http://www.w3.org/2000/svg" width="400" height="250" viewBox="0 0 400 250">
                                                    <defs>
                                                        <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
                                                            <stop offset="0%" style="stop-color:#DC143C;stop-opacity:1" />
                                                            <stop offset="100%" style="stop-color:#B71C1C;stop-opacity:1" />
                                                        </linearGradient>
                                                    </defs>
                                                    <rect width="400" height="250" fill="url(#grad)"/>
                                                    <circle cx="200" cy="100" r="30" fill="white" opacity="0.3"/>
                                                    <rect x="185" y="85" width="30" height="30" fill="white" opacity="0.5"/>
                                                    <text x="200" y="160" font-family="Arial, sans-serif" font-size="18" font-weight="bold" fill="white" text-anchor="middle">PMI Berita</text>
                                                </svg>
                                            ');
                                            // Jika tidak ada gambar_url, langsung gunakan placeholder
                                            if (!$gambarUrl) {
                                                $gambarUrl = $placeholderSvg;
                                            }
                                        @endphp
                                        <img src="{{ $gambarUrl }}" 
                                             alt="{{ $berita->judul ?? 'Berita' }}" 
                                             class="blog-img blog-list-image"
                                             data-gambar="{{ $berita->gambar ?? 'no-image' }}"
                                             style="width: 100%; height: 100%; object-fit: cover; display: block; opacity: 0; transition: opacity 0.3s ease;"
                                             loading="lazy"
                                             onerror="if (this.src.indexOf('data:image') === -1) { this.src = '{{ $placeholderSvg }}'; } this.style.opacity='1'; this.style.display='block';"
                                             onload="this.style.opacity='1'; this.style.display='block';">
                                    </a>
                                    @if(isset($berita->kategori_berita_id) && $berita->kategori)
                                    <div class="blog-tag" style="position: absolute; top: 12px; left: 12px; background: rgba(220, 20, 60, 0.95); color: #fff; padding: 6px 14px; border-radius: 20px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; z-index: 10; box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
                                        <a href="{{ route('frontend.berita', ['kategori' => $berita->kategori_berita_id]) }}" style="color: #fff; text-decoration: none;">
                                            {{ $berita->kategori->nama ?? 'Umum' }}
                                        </a>
                                    </div>
                                    @endif
                                </div>
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <span class="date"><i class="lni lni-calendar"></i> {{ $berita->published_at ? $berita->published_at->format('d M Y') : ($berita->created_at ? $berita->created_at->format('d M Y') : '') }}</span>
                                        <span class="author"><i class="lni lni-user"></i> {{ $berita->penulis ?? 'Admin' }}</span>
                                    </div>
                                    <h4 class="blog-title">
                                        <a href="{{ route('frontend.berita.detail', $berita->slug ?? '#') }}">{{ $berita->judul ?? 'Judul Berita' }}</a>
                                    </h4>
                                    <p class="text">{{ Str::limit($berita->ringkasan ?? (isset($berita->konten) ? strip_tags($berita->konten) : ''), 100) }}</p>
                                    <a href="{{ route('frontend.berita.detail', $berita->slug ?? '#') }}" class="more">Baca Selengkapnya <i class="lni lni-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <p>Tidak ada berita yang ditemukan.</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Pagination -->
                @if(isset($beritas) && method_exists($beritas, 'hasPages') && $beritas->hasPages())
                <div class="row">
                    <div class="col-12">
                        <div class="pagination">
                            {{ $beritas->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- End Blog Area -->

@push('scripts')
<script>
    function handleImageError(img, fallbackSrc) {
        if (img.hasAttribute('data-error-handled')) {
            return; // Already handled
        }
        img.setAttribute('data-error-handled', 'true');
        img.onerror = null;
        
        var currentSrc = img.src;
        var gambarField = img.getAttribute('data-gambar');
        
        // Jika gambar field ada tapi URL error, coba langsung dengan storage path
        if (gambarField && gambarField !== 'no-image' && currentSrc.indexOf('storage/') === -1) {
            var directUrl = '{{ url("/") }}/storage/' + gambarField;
            img.src = directUrl;
            return;
        }
        
        // Coba fallback image dulu
        if (fallbackSrc && (currentSrc.indexOf('blog-1.jpg') === -1 && currentSrc.indexOf('data:image') === -1)) {
            img.src = fallbackSrc;
            return;
        }
        
        // Jika sudah mencoba fallback atau langsung error, gunakan placeholder
        var placeholder = 'data:image/svg+xml;base64,' + btoa(`
            <svg xmlns="http://www.w3.org/2000/svg" width="400" height="250" viewBox="0 0 400 250">
                <defs>
                    <linearGradient id="grad` + Math.random().toString(36).substr(2, 9) + `" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#DC143C;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#B71C1C;stop-opacity:1" />
                    </linearGradient>
                </defs>
                <rect width="400" height="250" fill="url(#grad)"/>
                <circle cx="200" cy="100" r="30" fill="white" opacity="0.3"/>
                <rect x="185" y="85" width="30" height="30" fill="white" opacity="0.5"/>
                <text x="200" y="160" font-family="Arial, sans-serif" font-size="18" font-weight="bold" fill="white" text-anchor="middle">PMI Berita</text>
            </svg>
        `);
        img.src = placeholder;
        img.style.opacity = '1';
        img.style.display = 'block';
    }
    
    // Ensure images load properly
    document.addEventListener('DOMContentLoaded', function() {
        var images = document.querySelectorAll('.blog-list-image');
        images.forEach(function(img) {
            if (img.complete && img.naturalHeight !== 0) {
                // Image already loaded
                img.style.opacity = '1';
            } else {
                // Image still loading
                img.addEventListener('load', function() {
                    this.style.opacity = '1';
                });
            }
        });
    });
</script>
@endpush

@push('styles')
<style>
    /* Blog Image */
    .blog-image-wrapper {
        background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
    }
    .blog-img {
        transition: transform 0.4s ease;
    }
    .single-blog:hover .blog-img {
        transform: scale(1.08);
    }
    
    /* Blog Card */
    .single-blog {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        margin: 15px;
    }
    .single-blog:hover {
        box-shadow: 0 8px 30px rgba(220, 20, 60, 0.15);
        transform: translateY(-5px);
    }
    
    /* Blog Content */
    .blog-content {
        padding: 25px;
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #fff;
    }
    .blog-title {
        margin-top: 0;
        margin-bottom: 12px;
    }
    .blog-title a {
        color: #2c3e50;
        font-weight: 700;
        font-size: 1.15rem;
        line-height: 1.4;
        transition: color 0.3s ease;
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .blog-title a:hover {
        color: #DC143C;
    }
    .blog-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        font-size: 0.8rem;
        color: #7f8c8d;
        margin-bottom: 15px;
    }
    .blog-meta span {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .blog-meta i {
        color: #DC143C;
        font-size: 0.9rem;
    }
    .single-blog .text {
        color: #555;
        line-height: 1.7;
        margin-bottom: 18px;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .single-blog .more {
        color: #DC143C;
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        margin-top: auto;
    }
    .single-blog .more:hover {
        gap: 12px;
        color: #B71C1C;
    }
    .single-blog .more i {
        transition: transform 0.3s ease;
    }
    .single-blog .more:hover i {
        transform: translateX(3px);
    }
    
    /* Sidebar */
    .blog-sidebar .single-widget {
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        margin-bottom: 25px;
    }
    .blog-sidebar .single-widget h3 {
        color: #2c3e50;
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 3px solid #DC143C;
    }
    .blog-sidebar .search form {
        display: flex;
        gap: 8px;
    }
    .blog-sidebar .search input {
        flex: 1;
        padding: 12px 16px;
        border: 2px solid #e0e0e0;
        border-radius: 6px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }
    .blog-sidebar .search input:focus {
        outline: none;
        border-color: #DC143C;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(220, 20, 60, 0.1);
    }
    .blog-sidebar .search button {
        background: #DC143C;
        color: #fff;
        border: none;
        padding: 12px 18px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1.1rem;
    }
    .blog-sidebar .search button:hover {
        background: #B71C1C;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 20, 60, 0.3);
    }
    .blog-sidebar .categories ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .blog-sidebar .categories ul li {
        margin-bottom: 8px;
    }
    .blog-sidebar .categories ul li a {
        color: #555;
        text-decoration: none;
        padding: 10px 15px;
        display: block;
        border-radius: 6px;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }
    .blog-sidebar .categories ul li a:hover,
    .blog-sidebar .categories ul li a.active {
        background: rgba(220, 20, 60, 0.08);
        color: #DC143C;
        font-weight: 600;
        padding-left: 20px;
        border-left-color: #DC143C;
    }
    
    /* Pagination */
    .pagination {
        justify-content: center;
        margin-top: 40px;
    }
    
    /* Responsive */
    @media (max-width: 991px) {
        .blog-sidebar {
            position: static !important;
            margin-bottom: 40px;
        }
        .breadcrumbs-content h1 {
            font-size: 2rem !important;
        }
        .single-blog {
            margin: 0 0 25px 0;
        }
    }
    @media (max-width: 768px) {
        .breadcrumbs-content h1 {
            font-size: 1.75rem !important;
        }
        .breadcrumbs {
            padding: 50px 0 40px !important;
        }
        .blog-area {
            padding: 40px 0 !important;
        }
    }
</style>
@endpush
@endsection

