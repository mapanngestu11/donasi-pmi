@extends('frontend.layout')

@section('title', 'Pembayaran - Donasi PMI')

@section('content')
<!-- Start Hero Area -->
<section class="hero-area" style="padding: 100px 0 50px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center">
                    <h2>Pembayaran Donasi</h2>
                    <p>Selesaikan pembayaran Anda melalui Midtrans</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Hero Area -->

<!-- Start Payment Section -->
<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12 col-12">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h4 class="mb-4">Detail Donasi</h4>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Nama</strong></td>
                                        <td>: {{ $donasi->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td>: {{ $donasi->email }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Program</strong></td>
                                        <td>: {{ $donasi->program }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jumlah</strong></td>
                                        <td>: <strong class="text-primary">Rp {{ number_format($donasi->jumlah, 0, ',', '.') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Order ID</strong></td>
                                        <td>: <code>{{ $donasi->order_id }}</code></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-4">Metode Pembayaran</h4>
                                <div id="snap-container">
                                    <div id="snap-loading" class="text-center py-4">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-3">Memuat halaman pembayaran...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Payment Section -->

@push('scripts')
@php
    $midtransUrl = config('midtrans.is_production') 
        ? 'https://app.midtrans.com/snap/snap.js' 
        : 'https://app.sandbox.midtrans.com/snap/snap.js';
    $clientKey = config('midtrans.client_key');
@endphp

@if(empty($snapToken))
    <div class="alert alert-danger">
        <strong>Error:</strong> Snap token tidak tersedia. Silakan coba lagi atau hubungi administrator.
        <br><small>Order ID: {{ $donasi->order_id }}</small>
    </div>
@else
    <script>
        (function() {
            var snapToken = '{{ $snapToken }}';
            var clientKey = '{{ $clientKey }}';
            var midtransUrl = '{{ $midtransUrl }}';
            var maxRetries = 20;
            var retryCount = 0;
            var scriptLoaded = false;
            
            console.log('Initializing Midtrans Snap...');
            console.log('Client Key:', clientKey ? 'Set (' + clientKey.substring(0, 15) + '...)' : 'Not Set');
            console.log('Snap Token:', snapToken ? 'Available (' + snapToken.substring(0, 30) + '...)' : 'Not Available');
            console.log('Midtrans URL:', midtransUrl);
            
            function showError(message) {
                var container = document.getElementById('snap-container');
                var loadingEl = document.getElementById('snap-loading');
                if (loadingEl) loadingEl.style.display = 'none';
                if (container) {
                    container.innerHTML = 
                        '<div class="alert alert-danger text-center">' +
                        '<h5>Error</h5>' +
                        '<p>' + message + '</p>' +
                        '<button type="button" class="btn btn-primary mt-2" onclick="location.reload()">' +
                        '<i class="lni lni-reload"></i> Refresh Halaman' +
                        '</button>' +
                        '</div>';
                }
            }
            
            function openSnapPayment() {
                if (typeof window.snap !== 'undefined' && typeof window.snap.pay === 'function') {
                    console.log('Midtrans Snap is ready, opening payment popup...');
                    
                    // Hide loading
                    var loadingEl = document.getElementById('snap-loading');
                    if (loadingEl) {
                        loadingEl.style.display = 'none';
                    }
                    
                    try {
                        // Open Snap payment popup
                        window.snap.pay(snapToken, {
                            onSuccess: function(result){
                                console.log('Payment success:', result);
                                window.location.href = '{{ route("donasi.finish") }}?order_id=' + result.order_id;
                            },
                            onPending: function(result){
                                console.log('Payment pending:', result);
                                window.location.href = '{{ route("donasi.unfinish") }}?order_id=' + result.order_id;
                            },
                            onError: function(result){
                                console.log('Payment error:', result);
                                window.location.href = '{{ route("donasi.error") }}?order_id=' + result.order_id;
                            },
                            onClose: function(){
                                console.log('Payment popup closed');
                                // Show message in container
                                var container = document.getElementById('snap-container');
                                if (container) {
                                    container.innerHTML = 
                                        '<div class="alert alert-warning text-center">' +
                                        '<h5>Pembayaran Dibatalkan</h5>' +
                                        '<p>Anda menutup halaman pembayaran. Klik tombol di bawah untuk mencoba lagi.</p>' +
                                        '<button type="button" class="btn btn-primary" onclick="location.reload()">' +
                                        '<i class="lni lni-reload"></i> Coba Lagi' +
                                        '</button>' +
                                        '</div>';
                                }
                            }
                        });
                    } catch (e) {
                        console.error('Error opening Snap payment:', e);
                        showError('Gagal membuka halaman pembayaran: ' + e.message);
                    }
                } else {
                    retryCount++;
                    if (retryCount < maxRetries) {
                        console.log('Waiting for Midtrans Snap to load... (' + retryCount + '/' + maxRetries + ')');
                        setTimeout(openSnapPayment, 300);
                    } else {
                        console.error('Failed to load Midtrans Snap after ' + maxRetries + ' retries');
                        showError('Gagal memuat Midtrans Snap. Silakan refresh halaman atau cek koneksi internet Anda.');
                    }
                }
            }
            
            // Load Midtrans script
            function loadMidtransScript() {
                var script = document.createElement('script');
                script.src = midtransUrl;
                script.setAttribute('data-client-key', clientKey);
                script.id = 'midtrans-script';
                
                script.onload = function() {
                    console.log('Midtrans script loaded successfully');
                    scriptLoaded = true;
                    // Wait a bit for snap object to be available
                    setTimeout(openSnapPayment, 500);
                };
                
                script.onerror = function() {
                    console.error('Failed to load Midtrans script');
                    showError('Gagal memuat script Midtrans. Silakan cek koneksi internet dan coba lagi.');
                };
                
                document.head.appendChild(script);
                
                // Fallback: start checking after 1 second even if onload didn't fire
                setTimeout(function() {
                    if (!scriptLoaded) {
                        console.log('Script load timeout, trying to open payment anyway...');
                        openSnapPayment();
                    }
                }, 3000);
            }
            
            // Start loading script when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', loadMidtransScript);
            } else {
                loadMidtransScript();
            }
        })();
    </script>
@endif
@endpush
@endsection

