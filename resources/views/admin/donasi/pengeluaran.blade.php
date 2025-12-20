@extends('admin.layout')

@section('title', 'Pengeluaran - Admin Donasi PMI')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Laporan Pengeluaran</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item">Donasi</li>
    <li class="breadcrumb-item active" aria-current="page">Pengeluaran</li>
  </ol>
</div>

@if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif

<div class="row mb-3">
  <div class="col-lg-12">
    <a href="{{ route('admin.donasi.pengeluaran.create') }}" class="btn btn-primary mb-3">
      <i class="fas fa-plus"></i> Tambah Pengeluaran
    </a>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #f8f9fc !important; border-bottom: 1px solid #e3e6f0;">
        <h6 class="m-0 font-weight-bold" style="color: #4e73df;">Data Pengeluaran</h6>
      </div>
      <div class="table-responsive p-3">
        <table class="table align-items-center table-flush table-hover dataTable" id="dataTablePengeluaran">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Kegiatan</th>
              <th>Rincian</th>
              <th>Besar Anggaran</th>
              <th>File</th>
              <th>Penanggung Jawab</th>
              <th>Foto</th>
              <th>Aksi</th>
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

<!-- Modal untuk menampilkan foto -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel">Foto Kegiatan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img id="modalImage" src="" alt="Foto" class="img-fluid">
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('assets/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
  #modalImage {
    max-height: 80vh;
  }
</style>
@endpush

@push('scripts')
<!-- Page level plugins -->
<script src="{{ asset('assets/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
  function showImageModal(imageUrl) {
    $('#modalImage').attr('src', imageUrl);
    $('#imageModal').modal('show');
  }

  function deletePengeluaran(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data pengeluaran ini?')) {
      var form = document.createElement('form');
      form.method = 'POST';
      form.action = '/admin/donasi/pengeluaran/delete/' + id;
      form.innerHTML = '@csrf';
      document.body.appendChild(form);
      form.submit();
    }
  }

  $(document).ready(function() {
    $('#dataTablePengeluaran').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{ route('admin.donasi.pengeluaran.index') }}",
        type: 'GET'
      },
      columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'nama_kegiatan', name: 'nama_kegiatan' },
        { data: 'rincian', name: 'rincian' },
        { data: 'besar_anggaran', name: 'besar_anggaran', orderable: false },
        { data: 'file', name: 'file', orderable: false, searchable: false },
        { data: 'penanggung_jawab', name: 'penanggung_jawab' },
        { data: 'foto', name: 'foto', orderable: false, searchable: false },
        { 
          data: 'aksi', 
          name: 'aksi', 
          orderable: false, 
          searchable: false,
          render: function(data, type, row) {
            return '<a href="/admin/donasi/pengeluaran/edit/' + row.id + '" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a> ' +
                   '<button onclick="deletePengeluaran(' + row.id + ')" class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
          }
        }
      ],
      order: [[0, 'asc']],
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
  });
</script>
@endpush

