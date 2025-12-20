@extends('frontend.layout')

@section('title', 'Status Donasi - Donasi PMI')

@section('content')
<!-- Start Hero Area -->
<section class="hero-area" style="padding: 100px 0 50px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center">
                    <h2>Status Donasi</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Hero Area -->

<!-- Start Status Section -->
<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">
                <div class="card shadow-lg">
                    <div class="card-body p-5 text-center">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('warning'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                {{ session('warning') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @php
                            $status = $donasi->transaction_status;
                            
                            if ($status == 'settlement') {
                                $statusClass = 'success';
                                $statusText = 'Berhasil';
                                $statusIcon = 'lni-checkmark-circle';
                            } elseif ($status == 'pending') {
                                $statusClass = 'warning';
                                $statusText = 'Menunggu Pembayaran';
                                $statusIcon = 'lni-time';
                            } elseif ($status == 'expire') {
                                $statusClass = 'danger';
                                $statusText = 'Kedaluwarsa';
                                $statusIcon = 'lni-close-circle';
                            } elseif ($status == 'cancel') {
                                $statusClass = 'secondary';
                                $statusText = 'Dibatalkan';
                                $statusIcon = 'lni-close-circle';
                            } else {
                                $statusClass = 'info';
                                $statusText = 'Pending';
                                $statusIcon = 'lni-question-circle';
                            }
                        @endphp

                        <div class="mb-4">
                            <i class="lni {{ $statusIcon }}" style="font-size: 80px; color: var(--bs-{{ $statusClass }});"></i>
                        </div>

                        <h3 class="mb-3">Status: 
                            <span class="badge bg-{{ $statusClass }} fs-6">{{ $statusText }}</span>
                        </h3>

                        <div class="card mt-4">
                            <div class="card-body text-start">
                                <h5 class="card-title mb-4">Detail Donasi</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="40%"><strong>Order ID</strong></td>
                                        <td>: <code>{{ $donasi->order_id }}</code></td>
                                    </tr>
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
                                        <td><strong>Jumlah Donasi</strong></td>
                                        <td>: <strong class="text-primary">Rp {{ number_format($donasi->jumlah, 0, ',', '.') }}</strong></td>
                                    </tr>
                                    @if($donasi->transaction_id)
                                    <tr>
                                        <td><strong>Transaction ID</strong></td>
                                        <td>: <code>{{ $donasi->transaction_id }}</code></td>
                                    </tr>
                                    @endif
                                    @if($donasi->payment_type)
                                    <tr>
                                        <td><strong>Metode Pembayaran</strong></td>
                                        <td>: {{ ucfirst(str_replace('_', ' ', $donasi->payment_type)) }}</td>
                                    </tr>
                                    @endif
                                    @if($donasi->transaction_time)
                                    <tr>
                                        <td><strong>Waktu Transaksi</strong></td>
                                        <td>: {{ $donasi->transaction_time->format('d M Y H:i:s') }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('home') }}" class="btn btn-primary me-2">
                                <i class="lni lni-home"></i> Kembali ke Beranda
                            </a>
                            @if($donasi->transaction_status == 'pending')
                            <a href="{{ route('donasi.create', ['program' => $donasi->program, 'jumlah' => $donasi->jumlah]) }}" class="btn btn-outline-primary">
                                <i class="lni lni-reload"></i> Coba Lagi
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Status Section -->
@endsection

