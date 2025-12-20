@extends('admin.layout')

@section('title', 'Kategori Berita - Admin Donasi PMI')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Kategori Berita</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item">Berita</li>
    <li class="breadcrumb-item active" aria-current="page">Kategori</li>
  </ol>
</div>

<div class="row">
  <div class="col-lg-4">
    <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Form Kategori</h6>
      </div>
      <div class="card-body">
        <form id="kategoriForm">
          @csrf
          <input type="hidden" id="kategori_id" name="kategori_id">
          
          <div class="form-group">
            <label for="nama">Nama Kategori <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
              id="nama" name="nama" required>
            @error('nama')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
              id="deskripsi" name="deskripsi" rows="3"></textarea>
            @error('deskripsi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" checked>
              <label class="custom-control-label" for="is_active">
                Aktif
              </label>
            </div>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary" id="btnSubmit">
              <i class="fas fa-save"></i> Simpan
            </button>
            <button type="button" class="btn btn-secondary" id="btnCancel" style="display: none;">
              <i class="fas fa-times"></i> Batal
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #f8f9fc !important; border-bottom: 1px solid #e3e6f0;">
        <h6 class="m-0 font-weight-bold" style="color: #4e73df;">Data Kategori</h6>
      </div>
      <div class="table-responsive p-3">
        <table class="table align-items-center table-flush table-hover dataTable" id="dataTableHover">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Deskripsi</th>
              <th>Jumlah Berita</th>
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
    var table = $('#dataTableHover').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{ route('admin.berita.kategori.index') }}",
        type: 'GET'
      },
      columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'nama', name: 'nama' },
        { data: 'deskripsi', name: 'deskripsi' },
        { data: 'jumlah_berita', name: 'jumlah_berita' },
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

    // Handle form submit
    $('#kategoriForm').on('submit', function(e) {
      e.preventDefault();
      
      var formData = new FormData(this);
      var kategoriId = $('#kategori_id').val();
      var url = kategoriId 
        ? "{{ route('admin.berita.kategori.update', '') }}/" + kategoriId
        : "{{ route('admin.berita.kategori.store') }}";
      var method = kategoriId ? 'PUT' : 'POST';

      $.ajax({
        url: url,
        type: method,
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          if (response.success) {
            alert(response.message);
            $('#kategoriForm')[0].reset();
            $('#kategori_id').val('');
            $('#btnCancel').hide();
            table.ajax.reload();
          }
        },
        error: function(xhr) {
          var errors = xhr.responseJSON?.errors;
          if (errors) {
            var errorMessage = '';
            $.each(errors, function(key, value) {
              errorMessage += value[0] + '\n';
            });
            alert(errorMessage);
          } else {
            alert('Terjadi kesalahan saat menyimpan data.');
          }
        }
      });
    });

    // Handle cancel button
    $('#btnCancel').on('click', function() {
      $('#kategoriForm')[0].reset();
      $('#kategori_id').val('');
      $(this).hide();
      $('#btnSubmit').html('<i class="fas fa-save"></i> Simpan');
    });
  });

  function editKategori(id) {
    $.ajax({
      url: "{{ route('admin.berita.kategori.show', '') }}/" + id,
      type: 'GET',
      success: function(response) {
        $('#kategori_id').val(response.id);
        $('#nama').val(response.nama);
        $('#deskripsi').val(response.deskripsi);
        $('#is_active').prop('checked', response.is_active == 1);
        $('#btnCancel').show();
        $('#btnSubmit').html('<i class="fas fa-save"></i> Update');
      }
    });
  }

  function deleteKategori(id) {
    if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
      $.ajax({
        url: "{{ route('admin.berita.kategori.destroy', '') }}/" + id,
        type: 'DELETE',
        data: {
          _token: "{{ csrf_token() }}"
        },
        success: function(response) {
          if (response.success) {
            alert(response.message);
            $('#dataTableHover').DataTable().ajax.reload();
          }
        },
        error: function(xhr) {
          var response = xhr.responseJSON;
          alert(response?.message || 'Terjadi kesalahan saat menghapus data.');
        }
      });
    }
  }
</script>
@endpush

