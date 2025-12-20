@extends('admin.layout')

@section('title', 'Edit Berita - Admin Donasi PMI')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Edit Berita</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item">Berita</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.berita.index') }}">List Berita</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
  </ol>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Berita</h6>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          
          <div class="form-group">
            <label for="kategori_berita_id">Kategori <span class="text-danger">*</span></label>
            <select class="form-control @error('kategori_berita_id') is-invalid @enderror" 
              id="kategori_berita_id" name="kategori_berita_id" required>
              <option value="">-- Pilih Kategori --</option>
              @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id }}" 
                  {{ (old('kategori_berita_id', $berita->kategori_berita_id) == $kategori->id) ? 'selected' : '' }}>
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
              id="judul" name="judul" value="{{ old('judul', $berita->judul) }}" required>
            @error('judul')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="ringkasan">Ringkasan</label>
            <textarea class="form-control @error('ringkasan') is-invalid @enderror" 
              id="ringkasan" name="ringkasan" rows="3">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
            <small class="form-text text-muted">Ringkasan singkat tentang berita (opsional)</small>
            @error('ringkasan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="konten">Konten <span class="text-danger">*</span></label>
            <textarea class="form-control @error('konten') is-invalid @enderror" 
              id="konten" name="konten" rows="10" required>{{ old('konten', $berita->konten) }}</textarea>
            @error('konten')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="gambar">Gambar</label>
            
            <!-- Gambar yang sudah ada -->
            @if($berita->gambar)
              <div class="mb-3" id="currentImageWrapper">
                <label class="text-muted small">Gambar Saat Ini:</label>
                <div class="position-relative d-inline-block">
                  <img id="currentImage" 
                       src="{{ $berita->gambar_url }}" 
                       alt="{{ $berita->judul }}" 
                       class="img-thumbnail"
                       style="max-width: 400px; max-height: 250px; object-fit: cover; border-radius: 8px; cursor: pointer;"
                       onclick="document.getElementById('gambar').click()">
                  <div class="position-absolute" style="top: 10px; right: 10px;">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeCurrentImage()" title="Hapus gambar">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="mt-2">
                  <small class="text-muted d-block">Klik gambar untuk mengganti</small>
                </div>
              </div>
            @endif
            
            <!-- Input file -->
            <input type="file" 
                   class="form-control-file @error('gambar') is-invalid @enderror" 
                   id="gambar" 
                   name="gambar" 
                   accept="image/*" 
                   onchange="previewImage(this)">
            
            <!-- Hidden input untuk hapus gambar -->
            <input type="hidden" id="remove_image" name="remove_image" value="0">
            
            <small class="form-text text-muted">
              Maksimal 2MB. Format: JPEG, PNG, JPG, GIF. 
              @if($berita->gambar)
                Kosongkan jika tidak ingin mengubah gambar. Gambar yang sudah ada akan tetap digunakan.
              @endif
            </small>
            
            @error('gambar')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            
            <!-- Preview gambar baru -->
            <div id="imagePreview" class="mt-3" style="display: none;">
              <label class="text-muted small">Preview Gambar Baru:</label>
              <div class="position-relative d-inline-block">
                <img id="previewImg" 
                     src="" 
                     alt="Preview" 
                     class="img-thumbnail"
                     style="max-width: 400px; max-height: 250px; object-fit: cover; border-radius: 8px;">
                <div class="position-absolute" style="top: 10px; right: 10px;">
                  <button type="button" class="btn btn-sm btn-secondary" onclick="cancelNewImage()" title="Batal">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="penulis">Penulis</label>
            <input type="text" class="form-control @error('penulis') is-invalid @enderror" 
              id="penulis" name="penulis" value="{{ old('penulis', $berita->penulis) }}">
            @error('penulis')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="is_published" name="is_published" 
                value="1" {{ old('is_published', $berita->is_published) ? 'checked' : '' }}>
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

@push('styles')
<style>
  .img-thumbnail {
    border: 2px solid #dee2e6;
    transition: all 0.3s ease;
  }
  .img-thumbnail:hover {
    border-color: #DC143C;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  }
</style>
@endpush

@push('scripts')
<script>
  function previewImage(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('imagePreview').style.display = 'block';
        
        // Sembunyikan gambar lama jika ada
        var currentImageWrapper = document.getElementById('currentImageWrapper');
        if (currentImageWrapper) {
          currentImageWrapper.style.display = 'none';
        }
      }
      
      reader.readAsDataURL(input.files[0]);
    } else {
      document.getElementById('imagePreview').style.display = 'none';
      
      // Tampilkan kembali gambar lama jika ada
      var currentImageWrapper = document.getElementById('currentImageWrapper');
      if (currentImageWrapper) {
        currentImageWrapper.style.display = 'block';
      }
    }
  }
  
  function removeCurrentImage() {
    if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
      document.getElementById('remove_image').value = '1';
      document.getElementById('currentImageWrapper').style.display = 'none';
      document.getElementById('gambar').value = '';
    }
  }
  
  function cancelNewImage() {
    document.getElementById('gambar').value = '';
    document.getElementById('imagePreview').style.display = 'none';
    
    // Tampilkan kembali gambar lama jika ada
    var currentImageWrapper = document.getElementById('currentImageWrapper');
    if (currentImageWrapper && document.getElementById('remove_image').value == '0') {
      currentImageWrapper.style.display = 'block';
    }
  }
</script>
@endpush

