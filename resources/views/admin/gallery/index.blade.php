@extends('admin.layout')

@section('title', 'Gallery - Admin Donasi PMI')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Gallery</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Gallery</li>
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
    <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary mb-3">
      <i class="fas fa-plus"></i> Tambah Gallery
    </a>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #f8f9fc !important; border-bottom: 1px solid #e3e6f0;">
        <h6 class="m-0 font-weight-bold" style="color: #4e73df;">Data Gallery</h6>
      </div>
      <div class="table-responsive p-3">
        <table class="table align-items-center table-flush table-hover dataTable" id="dataTableGallery">
          <thead>
            <tr>
              <th>No</th>
              <th>Gambar</th>
              <th>Judul Kegiatan</th>
              <th>Deskripsi</th>
              <th>Tanggal</th>
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

<!-- Modal untuk menampilkan gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel">Gambar Gallery</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img id="modalImage" src="" alt="Gambar" class="img-fluid">
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

  function deleteGallery(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data gallery ini?')) {
      var form = document.createElement('form');
      form.method = 'POST';
      form.action = '/admin/gallery/delete/' + id;
      form.innerHTML = '@csrf';
      document.body.appendChild(form);
      form.submit();
    }
  }

  $(document).ready(function() {
    $('#dataTableGallery').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{ route('admin.gallery.index') }}",
        type: 'GET'
      },
      columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'gambar', name: 'gambar', orderable: false, searchable: false },
        { data: 'judul_kegiatan', name: 'judul_kegiatan' },
        { data: 'deskripsi', name: 'deskripsi' },
        { data: 'tanggal', name: 'tanggal' },
        { 
          data: 'aksi', 
          name: 'aksi', 
          orderable: false, 
          searchable: false
        }
      ],
      order: [[4, 'desc']], // Order by tanggal descending (index 4 = kolom tanggal)
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

