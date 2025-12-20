@extends('admin.layout')

@section('title', 'List Berita - Admin Donasi PMI')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">List Berita</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item">Berita</li>
    <li class="breadcrumb-item active" aria-current="page">List Berita</li>
  </ol>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{ session('success') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

<div class="row">
  <div class="col-lg-12">
    <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #f8f9fc !important; border-bottom: 1px solid #e3e6f0;">
        <h6 class="m-0 font-weight-bold" style="color: #4e73df;">Data Berita</h6>
        <a href="{{ route('admin.berita.create') }}" class="btn btn-primary btn-sm">
          <i class="fas fa-plus"></i> Tambah Berita
        </a>
      </div>
      <div class="table-responsive p-3">
        <table class="table align-items-center table-flush table-hover dataTable" id="dataTableHover">
          <thead>
            <tr>
              <th>No</th>
              <th>Gambar</th>
              <th>Judul</th>
              <th>Kategori</th>
              <th>Penulis</th>
              <th>Views</th>
              <th>Status</th>
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

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
  @csrf
  @method('DELETE')
</form>
@endsection

@push('styles')
<link href="{{ asset('assets/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<!-- Page level plugins -->
<script src="{{ asset('assets/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
  $(document).ready(function() {
    $('#dataTableHover').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{ route('admin.berita.index') }}",
        type: 'GET'
      },
      columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'gambar', name: 'gambar', orderable: false, searchable: false },
        { data: 'judul', name: 'judul' },
        { data: 'kategori', name: 'kategori' },
        { data: 'penulis', name: 'penulis' },
        { data: 'views', name: 'views' },
        { data: 'status', name: 'status', orderable: false, searchable: false },
        { data: 'tanggal', name: 'tanggal', orderable: false },
        { data: 'action', name: 'action', orderable: false, searchable: false }
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

  function deleteBerita(id) {
    if (confirm('Apakah Anda yakin ingin menghapus berita ini?')) {
      var form = document.getElementById('deleteForm');
      form.action = "{{ route('admin.berita.destroy', '') }}/" + id;
      form.submit();
    }
  }
</script>
@endpush

