@extends('admin.layout')

@section('title', 'Laporan Pendapatan & Pengeluaran - Admin Donasi PMI')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Laporan Pendapatan & Pengeluaran</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Laporan Keuangan</li>
  </ol>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Pendapatan</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-arrow-up fa-2x text-success"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-danger shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Pengeluaran</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-arrow-down fa-2x text-danger"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Saldo</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-wallet fa-2x text-primary"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #f8f9fc !important; border-bottom: 1px solid #e3e6f0;">
        <h6 class="m-0 font-weight-bold" style="color: #5a5c69;">Data Laporan Keuangan</h6>
        <div class="d-flex align-items-center" style="gap: 10px;">
          <select id="filterType" class="form-control form-control-sm" style="max-width: 180px; font-size: 14px;">
            <option value="">Semua</option>
            <option value="pendapatan">Pendapatan</option>
            <option value="pengeluaran">Pengeluaran</option>
          </select>
          <a href="{{ route('admin.laporan-keuangan.export.excel') }}" class="btn btn-success btn-sm" id="btnExportExcel" title="Export Excel">
            <i class="fas fa-file-excel"></i> Excel
          </a>
          <a href="{{ route('admin.laporan-keuangan.export.pdf') }}" class="btn btn-danger btn-sm" id="btnExportPdf" title="Export PDF" target="_blank">
            <i class="fas fa-file-pdf"></i> PDF
          </a>
        </div>
      </div>
      <div class="table-responsive p-3">
        <table class="table align-items-center table-flush table-hover dataTable" id="dataTableHover">
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
            <!-- Data akan di-load via DataTables AJAX -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('assets/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<!-- Page level plugins -->
<script src="{{ asset('assets/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
  let table;
  
  $(document).ready(function() {
    table = $('#dataTableHover').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{ route('admin.laporan-keuangan.index') }}",
        type: 'GET',
        data: function(d) {
          d.type_filter = $('#filterType').val();
        }
      },
      columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        { 
          data: 'type', 
          name: 'type',
          render: function(data, type, row) {
            if (data == 'Pendapatan') {
              return '<span class="badge badge-success">' + data + '</span>';
            } else {
              return '<span class="badge badge-danger">' + data + '</span>';
            }
          }
        },
        { data: 'tanggal', name: 'tanggal', orderable: false },
        { data: 'keterangan', name: 'keterangan' },
        { data: 'detail', name: 'detail' },
        { data: 'nama', name: 'nama' },
        { data: 'bank', name: 'bank' },
        { 
          data: 'nominal', 
          name: 'nominal',
          orderable: false,
          render: function(data, type, row) {
            if (row.type == 'Pendapatan') {
              return '<span class="text-success font-weight-bold">' + data + '</span>';
            } else {
              return '<span class="text-danger font-weight-bold">' + data + '</span>';
            }
          }
        }
      ],
      order: [[2, 'desc']], // Sort by tanggal descending
      language: {
        processing: "Memproses...",
        lengthMenu: "Tampilkan _MENU_ data per halaman",
        zeroRecords: "Tidak ada data yang ditemukan",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
        infoFiltered: "(disaring dari _MAX_ total data)",
        search: "Cari:",
        paginate: {
          first: "Pertama",
          last: "Terakhir",
          next: "Selanjutnya",
          previous: "Sebelumnya"
        }
      },
      pageLength: 25,
      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
      dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
      responsive: true
    });

    // Filter type change
    $('#filterType').on('change', function() {
      table.ajax.reload();
      
      // Update export button URLs with filter
      var typeFilter = $(this).val();
      var exportExcelUrl = "{{ route('admin.laporan-keuangan.export.excel') }}";
      var exportPdfUrl = "{{ route('admin.laporan-keuangan.export.pdf') }}";
      if (typeFilter) {
        exportExcelUrl += '?type=' + typeFilter;
        exportPdfUrl += '?type=' + typeFilter;
      }
      $('#btnExportExcel').attr('href', exportExcelUrl);
      $('#btnExportPdf').attr('href', exportPdfUrl);
    });
  });
</script>
@endpush

