@extends('frontend.layout')

@section('title', 'Gallery - Donasi PMI')

@section('content')
<!-- Start Breadcrumbs -->
<section class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-content">
                    <h1 class="page-title">Gallery Kegiatan</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Breadcrumbs -->

<!-- Start Gallery Area -->
<section class="gallery-area section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center">
                    <span class="wow fadeInDown" data-wow-delay=".2s">Gallery</span>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Kegiatan Kami</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Lihat dokumentasi kegiatan dan program yang telah kami lakukan</p>
                </div>
            </div>
        </div>
        <div class="row">
            @forelse($galleries as $gallery)
            <div class="col-lg-4 col-md-6 col-12">
                <div class="single-gallery">
                    <div class="gallery-image">
                        @if($gallery->gambar)
                        <a href="javascript:void(0)" 
                           class="gallery-modal-trigger" 
                           data-image="{{ $gallery->gambar_url }}"
                           data-title="{{ $gallery->judul_kegiatan }}"
                           data-description="{{ $gallery->deskripsi }}"
                           data-date="{{ $gallery->tanggal ? $gallery->tanggal->format('d M Y') : $gallery->created_at->format('d M Y') }}">
                            <img src="{{ $gallery->gambar_url }}" alt="{{ $gallery->judul_kegiatan }}">
                            <div class="gallery-overlay">
                                <i class="lni lni-zoom-in"></i>
                            </div>
                        </a>
                        @else
                        <img src="{{ asset('assets/images/gallery/gallery-1.jpg') }}" alt="{{ $gallery->judul_kegiatan }}">
                        @endif
                    </div>
                    <div class="gallery-content">
                        <h4>{{ $gallery->judul_kegiatan }}</h4>
                        <p>{{ Str::limit($gallery->deskripsi, 100) }}</p>
                        <span class="date"><i class="lni lni-calendar"></i> {{ $gallery->tanggal ? $gallery->tanggal->format('d M Y') : $gallery->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <p>Belum ada gallery yang tersedia.</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($galleries->hasPages())
        <div class="row">
            <div class="col-12">
                <div class="pagination">
                    {{ $galleries->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
<!-- End Gallery Area -->

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

@push('styles')
<style>
    /* Breadcrumbs Styling */
    .breadcrumbs {
        background-color: #DC143C !important;
        background: linear-gradient(135deg, #DC143C 0%, #b01030 100%);
    }
    
    /* Gallery Section Styling */
    .gallery-area {
        padding: 80px 0;
        background-color: #fff;
    }
    
    .section-title {
        margin-bottom: 50px;
    }
    
    .section-title span {
        display: inline-block;
        color: #DC143C;
        font-size: 16px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }
    
    .section-title h2 {
        font-size: 36px;
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
    }
    
    .section-title p {
        font-size: 16px;
        color: #666;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }
    
    /* Gallery Card Styling */
    .single-gallery {
        margin-bottom: 30px;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .single-gallery:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 25px rgba(220, 20, 60, 0.15);
    }
    
    .gallery-image {
        position: relative;
        overflow: hidden;
        height: 280px;
        background-color: #f5f5f5;
    }
    
    .gallery-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    
    .single-gallery:hover .gallery-image img {
        transform: scale(1.08);
    }
    
    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(220, 20, 60, 0.7), rgba(220, 20, 60, 0.9));
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .single-gallery:hover .gallery-overlay {
        opacity: 1;
    }
    
    .gallery-overlay i {
        color: #fff;
        font-size: 40px;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }
    
    .gallery-content {
        padding: 25px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .gallery-content h4 {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 12px;
        color: #333;
        line-height: 1.4;
        min-height: 56px;
    }
    
    .gallery-content p {
        color: #666;
        margin-bottom: 15px;
        font-size: 14px;
        line-height: 1.6;
        flex-grow: 1;
    }
    
    .gallery-content .date {
        color: #999;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .gallery-content .date i {
        color: #DC143C;
        font-size: 14px;
    }
    
    /* Pagination Styling */
    .pagination {
        margin-top: 50px;
        display: flex;
        justify-content: center;
    }
    
    .pagination .page-link {
        color: #DC143C;
        border-color: #DC143C;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #DC143C;
        border-color: #DC143C;
    }
    
    .pagination .page-link:hover {
        color: #fff;
        background-color: #DC143C;
        border-color: #DC143C;
    }
    
    /* Empty State */
    .alert-info {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 30px;
        color: #666;
    }
    
    /* Responsive */
    @media (max-width: 991px) {
        .gallery-area {
            padding: 60px 0;
        }
        
        .section-title h2 {
            font-size: 28px;
        }
        
        .gallery-image {
            height: 240px;
        }
    }
    
    @media (max-width: 767px) {
        .gallery-area {
            padding: 40px 0;
        }
        
        .section-title h2 {
            font-size: 24px;
        }
        
        .section-title p {
            font-size: 14px;
        }
        
        .gallery-image {
            height: 200px;
        }
        
        .gallery-content {
            padding: 20px;
        }
        
        .gallery-content h4 {
            font-size: 18px;
            min-height: auto;
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
</style>
@endpush

@push('scripts')
<script>
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
</script>
@endpush

