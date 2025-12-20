@extends('admin.layout')

@section('title', 'Dashboard - Admin Donasi PMI')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
  </ol>
</div>

<div class="row mb-3">
  <!-- Total Pendapatan Card -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100 border-left-success">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pendapatan</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</div>
            <div class="mt-2 mb-0 text-muted text-xs">
              <span>Dari semua donasi</span>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-money-bill-wave fa-2x text-success"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Total Pengeluaran Card -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100 border-left-danger">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pengeluaran</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}</div>
            <div class="mt-2 mb-0 text-muted text-xs">
              <span>Total anggaran</span>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-credit-card fa-2x text-danger"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Jumlah Donatur Card -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100 border-left-info">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah Donatur</div>
            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ number_format($jumlahDonatur ?? 0, 0, ',', '.') }}</div>
            <div class="mt-2 mb-0 text-muted text-xs">
              <span>Donatur aktif</span>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-users fa-2x text-info"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Jumlah Kegiatan Card -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100 border-left-warning">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah Kegiatan</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($jumlahKegiatan ?? 0, 0, ',', '.') }}</div>
            <div class="mt-2 mb-0 text-muted text-xs">
              <span>Total gallery</span>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-images fa-2x text-warning"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Grafik Pemasukan dan Tabel Donasi Terbaru dalam 1 Row -->
  <div class="col-xl-8 col-lg-7 mb-4">
    <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #f8f9fc !important; border-bottom: 1px solid #e3e6f0;">
        <h6 class="m-0 font-weight-bold" style="color: #4e73df;">Grafik Pemasukan</h6>
      </div>
      <div class="card-body">
        <div class="chart-area">
          <canvas id="myAreaChart"></canvas>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Tabel Donasi Terbaru -->
  <div class="col-xl-4 col-lg-5 mb-4">
    <div class="card">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #f8f9fc !important; border-bottom: 1px solid #e3e6f0;">
        <h6 class="m-0 font-weight-bold" style="color: #4e73df;">Donasi Terkini</h6>
        <a class="m-0 float-right btn btn-primary btn-sm" href="{{ route('admin.donasi.laporan') }}">Lihat Semua <i
            class="fas fa-chevron-right"></i></a>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center table-flush">
          <thead>
            <tr>
              <th>Donatur</th>
              <th>Jumlah</th>
              <th>Pesan</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($donasiTerbaru ?? [] as $donasi)
            <tr>
              <td>
                <div class="font-weight-bold">{{ Str::limit($donasi->nama ?? 'Anonim', 15) }}</div>
                <div class="small text-muted">{{ $donasi->created_at ? $donasi->created_at->format('d M Y') : '-' }}</div>
              </td>
              <td>
                <div class="font-weight-bold text-success">Rp {{ number_format($donasi->jumlah ?? 0, 0, ',', '.') }}</div>
              </td>
              <td>
                @php
                  $pesan = $donasi->keterangan_pesan ?? $donasi->pesan ?? '-';
                @endphp
                <div class="small text-muted" style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $pesan }}">
                  {{ Str::limit($pesan, 30) }}
                </div>
              </td>
              <td>
                @if($donasi->transaction_status == 'settlement')
                  <span class="badge badge-success">Berhasil</span>
                @elseif($donasi->transaction_status == 'pending')
                  <span class="badge badge-warning">Pending</span>
                @else
                  <span class="badge badge-danger">{{ ucfirst($donasi->transaction_status ?? 'Unknown') }}</span>
                @endif
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center text-muted py-3">Belum ada donasi</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!--Row-->

@push('styles')
<style>
  .border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
  }
  .border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
  }
  .border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
  }
  .border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
  }
  .chart-area {
    position: relative;
    height: 300px;
    width: 100%;
  }
</style>
@endpush
@endsection

@push('scripts')
<script src="{{ asset('assets/admin/vendor/chart.js/Chart.min.js') }}"></script>
<script>
// Area Chart - Grafik Pemasukan
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: {!! json_encode($labels ?? []) !!},
    datasets: [{
      label: "Pemasukan",
      lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.05)",
      borderColor: "rgba(78, 115, 223, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(78, 115, 223, 1)",
      pointBorderColor: "rgba(78, 115, 223, 1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: {!! json_encode($bulanan ?? []) !!},
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          callback: function(value, index, values) {
            return 'Rp ' + number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ': Rp ' + number_format(tooltipItem.yLabel);
        }
      }
    }
  }
});

function number_format(number, decimals, dec_point, thousands_sep) {
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}
</script>
@endpush

