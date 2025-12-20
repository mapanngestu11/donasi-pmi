@extends('frontend.layout')

@section('title', $berita->judul . ' - Donasi PMI')

@section('content')
<!-- Start Breadcrumbs -->
<section class="breadcrumbs" style="background: linear-gradient(135deg, #DC143C 0%, #B71C1C 100%); padding: 60px 0 40px; margin-top: 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-content">
                    <h1 class="page-title" style="color: #fff; font-size: 2rem; font-weight: 700; line-height: 1.3; margin: 0;">{{ $berita->judul }}</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Breadcrumbs -->

<!-- Start Blog Details Area -->
<section class="blog-details-area section" style="padding: 50px 0; background-color: #f8f9fa;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="card blog-details-card">
                    <!-- Blog Image Card -->
                    <div class="card-img-top blog-details-image-wrapper">
                        @php
                            $gambarUrl = $berita->gambar_url;
                            $placeholderSvg = 'data:image/svg+xml;base64,' . base64_encode('
                                <svg xmlns="http://www.w3.org/2000/svg" width="800" height="400" viewBox="0 0 800 400">
                                    <defs>
                                        <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" style="stop-color:#DC143C;stop-opacity:1" />
                                            <stop offset="100%" style="stop-color:#B71C1C;stop-opacity:1" />
                                        </linearGradient>
                                    </defs>
                                    <rect width="800" height="400" fill="url(#grad)"/>
                                    <circle cx="400" cy="150" r="50" fill="white" opacity="0.3"/>
                                    <rect x="370" y="120" width="60" height="60" fill="white" opacity="0.5"/>
                                    <text x="400" y="280" font-family="Arial, sans-serif" font-size="32" font-weight="bold" fill="white" text-anchor="middle">PMI Berita</text>
                                    <text x="400" y="320" font-family="Arial, sans-serif" font-size="18" fill="white" text-anchor="middle" opacity="0.9">Gambar tidak tersedia</text>
                                </svg>
                            ');
                            // Jika tidak ada gambar_url, langsung gunakan placeholder
                            if (!$gambarUrl) {
                                $gambarUrl = $placeholderSvg;
                            }
                        @endphp
                        <img src="{{ $gambarUrl }}" 
                             alt="{{ $berita->judul }}" 
                             class="blog-details-image"
                             data-gambar="{{ $berita->gambar ?? 'no-image' }}"
                             onerror="if (this.src.indexOf('data:image') === -1) { this.src = '{{ $placeholderSvg }}'; } this.style.opacity='1'; this.style.display='block';"
                             onload="this.style.opacity='1'; this.style.display='block';"
                             style="display: block; opacity: 0; transition: opacity 0.3s ease;">
                    </div>
                    
                    <!-- Blog Content Card Body -->
                    <div class="card-body blog-details-content">
                        <div class="blog-meta mb-3">
                            <span class="meta-item"><i class="lni lni-calendar"></i> {{ $berita->published_at ? $berita->published_at->format('d M Y') : $berita->created_at->format('d M Y') }}</span>
                            <span class="meta-item"><i class="lni lni-user"></i> {{ $berita->penulis ?? 'Admin PMI' }}</span>
                            <span class="meta-item"><i class="lni lni-eye"></i> {{ $berita->views ?? 0 }} views</span>
                            @if($berita->kategori)
                            <span class="meta-item category">
                                <a href="{{ route('frontend.berita', ['kategori' => $berita->kategori_berita_id]) }}">
                                    {{ $berita->kategori->nama }}
                                </a>
                            </span>
                            @endif
                        </div>
                        <h2 class="blog-title mb-3">{{ $berita->judul }}</h2>
                        @if($berita->ringkasan)
                        <p class="lead text-muted mb-4">{{ $berita->ringkasan }}</p>
                        @endif
                        <div class="blog-content">
                            {!! $berita->konten !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4 col-12">
                <div class="blog-sidebar">
                    <!-- Related Posts -->
                    @if($relatedBeritas->count() > 0)
                    <div class="card single-widget recent-post mb-4">
                        <div class="card-header">
                            <h3 class="mb-0">Berita Terkait</h3>
                        </div>
                        <div class="card-body">
                            @foreach($relatedBeritas as $related)
                            <div class="single-post mb-3 pb-3 border-bottom">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="image-wrapper">
                                            @php
                                                $relatedGambarUrl = $related->gambar_url ?? null;
                                                if ($related->gambar) {
                                                    $paths = [
                                                        storage_path('app/public/' . $related->gambar),
                                                        public_path('storage/' . $related->gambar),
                                                    ];
                                                    foreach ($paths as $path) {
                                                        if (file_exists($path)) {
                                                            $relatedGambarUrl = asset('storage/' . $related->gambar);
                                                            break;
                                                        }
                                                    }
                                                }
                                                if (!$relatedGambarUrl) {
                                                    $relatedGambarUrl = asset('assets/images/blog/blog-1.jpg');
                                                }
                                            @endphp
                                            <img src="{{ $relatedGambarUrl }}" 
                                                 alt="{{ $related->judul }}" 
                                                 class="related-image"
                                                 onerror="this.onerror=null; this.src='data:image/svg+xml;base64,' + btoa('<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'80\'><rect fill=\'%23DC143C\' width=\'100\' height=\'80\'/><text x=\'50%25\' y=\'50%25\' fill=\'white\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'12\'>PMI</text></svg>');">
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="content">
                                            <h5 class="mb-2">
                                                <a href="{{ route('frontend.berita.detail', $related->slug) }}">
                                                    {{ Str::limit($related->judul, 50) }}
                                                </a>
                                            </h5>
                                            <ul class="comment mb-0">
                                                <li><i class="lni lni-calendar"></i> {{ $related->published_at ? $related->published_at->format('d M Y') : $related->created_at->format('d M Y') }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Blog Details Area -->
@endsection

@push('styles')
<style>
    /* Blog Details Card */
    .blog-details-card {
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    /* Blog Image Wrapper */
    .blog-details-image-wrapper {
        width: 100%;
        min-height: 450px;
        max-height: 550px;
        overflow: hidden;
        background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        position: relative;
    }
    
    .blog-details-image {
        width: 100%;
        height: 100%;
        min-height: 450px;
        max-height: 550px;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
        background: #f5f5f5;
    }
    
    .blog-details-image:hover {
        transform: scale(1.03);
    }
    
    /* Loading state */
    .blog-details-image[style*="opacity: 0"] {
        background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
    }
    
    /* Blog Content */
    .blog-details-content {
        padding: 30px;
    }
    
    .blog-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        font-size: 14px;
        color: #666;
    }
    
    .blog-meta .meta-item {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .blog-meta .meta-item i {
        color: #DC143C;
    }
    
    .blog-meta .meta-item.category a {
        color: #DC143C;
        text-decoration: none;
        font-weight: 500;
    }
    
    .blog-meta .meta-item.category a:hover {
        text-decoration: underline;
    }
    
    .blog-title {
        font-size: 28px;
        font-weight: 700;
        color: #333;
        line-height: 1.4;
    }
    
    .blog-content {
        font-size: 16px;
        line-height: 1.8;
        color: #555;
        margin-top: 20px;
    }
    
    .blog-content p {
        margin-bottom: 15px;
    }
    
    .blog-content img {
        max-width: 100%;
        height: auto;
        border-radius: 6px;
        margin: 20px 0;
    }
    
    /* Related Posts Card */
    .single-widget.recent-post {
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-radius: 8px;
    }
    
    .single-widget .card-header {
        background-color: #DC143C;
        color: #fff;
        padding: 15px 20px;
        border-bottom: none;
    }
    
    .single-widget .card-header h3 {
        color: #fff;
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }
    
    .single-widget .card-body {
        padding: 20px;
    }
    
    .single-post {
        display: flex;
    }
    
    .single-post:last-child {
        border-bottom: none !important;
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }
    
    .image-wrapper {
        width: 100%;
        height: 80px;
        overflow: hidden;
        border-radius: 6px;
        background-color: #f5f5f5;
    }
    
    .related-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .single-post .content h5 {
        font-size: 14px;
        font-weight: 600;
        line-height: 1.4;
        margin-bottom: 8px;
    }
    
    .single-post .content h5 a {
        color: #333;
        text-decoration: none;
        transition: color 0.3s;
    }
    
    .single-post .content h5 a:hover {
        color: #DC143C;
    }
    
    .single-post .comment {
        list-style: none;
        padding: 0;
        margin: 0;
        font-size: 12px;
        color: #999;
    }
    
    .single-post .comment li {
        display: inline;
    }
    
    .single-post .comment i {
        margin-right: 3px;
    }
    
    /* Responsive */
    @media (max-width: 991px) {
        .blog-details-image-wrapper {
            height: 300px;
        }
        
        .blog-details-content {
            padding: 20px;
        }
        
        .blog-title {
            font-size: 24px;
        }
    }
    
    @media (max-width: 767px) {
        .blog-details-image-wrapper {
            height: 250px;
        }
        
        .blog-details-content {
            padding: 15px;
        }
        
        .blog-title {
            font-size: 20px;
        }
        
        .blog-meta {
            font-size: 12px;
            gap: 10px;
        }
        
        .blog-content {
            font-size: 14px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Ensure images load properly
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('.blog-details-image, .related-image');
        
        images.forEach(function(img) {
            // Check if image loaded successfully
            if (img.complete && img.naturalHeight !== 0) {
                img.style.display = 'block';
            } else {
                img.addEventListener('load', function() {
                    this.style.display = 'block';
                });
                
                img.addEventListener('error', function() {
                    // If error, try fallback
                    if (this.src.indexOf('blog-1.jpg') === -1) {
                        this.src = '{{ asset('assets/images/blog/blog-1.jpg') }}';
                    }
                    this.style.display = 'block';
                });
            }
        });
    });
</script>
@endpush

