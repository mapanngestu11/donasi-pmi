@extends('admin.layout')

@section('title', 'Tambah Berita - Admin Donasi PMI')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Tambah Berita</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item">Berita</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.berita.index') }}">List Berita</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
  </ol>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Berita</h6>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          
          <div class="form-group">
            <label for="kategori_berita_id">Kategori <span class="text-danger">*</span></label>
            <select class="form-control @error('kategori_berita_id') is-invalid @enderror" 
              id="kategori_berita_id" name="kategori_berita_id" required>
              <option value="">-- Pilih Kategori --</option>
              @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id }}" {{ old('kategori_berita_id') == $kategori->id ? 'selected' : '' }}>
                  {{ $kategori->nama }}
                </option>
              @endforeach
            </select>
            @error('kategori_berita_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="judul">Judul Berita <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('judul') is-invalid @enderror" 
              id="judul" name="judul" value="{{ old('judul') }}" required>
            @error('judul')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="ringkasan">Ringkasan</label>
            <textarea class="form-control @error('ringkasan') is-invalid @enderror" 
              id="ringkasan" name="ringkasan" rows="3">{{ old('ringkasan') }}</textarea>
            <small class="form-text text-muted">Ringkasan singkat tentang berita (opsional)</small>
            @error('ringkasan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="konten">Konten <span class="text-danger">*</span></label>
            <textarea class="form-control @error('konten') is-invalid @enderror" 
              id="konten" name="konten" rows="10" required>{{ old('konten') }}</textarea>
            @error('konten')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="gambar">Gambar</label>
            <input type="file" class="form-control-file @error('gambar') is-invalid @enderror" 
              id="gambar" name="gambar" accept="image/*" onchange="previewImage(this)">
            <small class="form-text text-muted">Maksimal 2MB. Format: JPEG, PNG, JPG, GIF</small>
            @error('gambar')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="imagePreview" class="mt-2" style="display: none;">
              <img id="previewImg" src="" alt="Preview" style="max-width: 300px; max-height: 200px; object-fit: cover; border-radius: 4px;">
            </div>
          </div>

          <div class="form-group">
            <label for="penulis">Penulis</label>
            <input type="text" class="form-control @error('penulis') is-invalid @enderror" 
              id="penulis" name="penulis" value="{{ old('penulis') }}">
            @error('penulis')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="is_published" name="is_published" 
                value="1" {{ old('is_published') ? 'checked' : '' }}>
              <label class="custom-control-label" for="is_published">
                Publikasikan berita
              </label>
            </div>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
              <i class="fas fa-times"></i> Batal
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function previewImage(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('imagePreview').style.display = 'block';
      }
      
      reader.readAsDataURL(input.files[0]);
    } else {
      document.getElementById('imagePreview').style.display = 'none';
    }
  }
</script>
@endpush

