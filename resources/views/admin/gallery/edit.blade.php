@extends('admin.layout')

@section('title', 'Edit Gallery - Admin Donasi PMI')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Edit Gallery</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.gallery.index') }}">Gallery</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
  </ol>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Gallery</h6>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          
          <div class="form-group">
            <label for="judul_kegiatan">Judul Kegiatan <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('judul_kegiatan') is-invalid @enderror" 
              id="judul_kegiatan" name="judul_kegiatan" value="{{ old('judul_kegiatan', $gallery->judul_kegiatan) }}" required>
            @error('judul_kegiatan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="deskripsi">Deskripsi <span class="text-danger">*</span></label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
              id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi', $gallery->deskripsi) }}</textarea>
            @error('deskripsi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
              id="tanggal" name="tanggal" value="{{ old('tanggal', $gallery->tanggal->format('Y-m-d')) }}" required>
            @error('tanggal')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="gambar">Gambar</label>
            @if($gallery->gambar)
              <div class="mb-2">
                <img src="{{ $gallery->gambar_url }}" alt="Gambar" style="max-width: 300px; max-height: 300px;" class="img-thumbnail">
              </div>
            @endif
            <input type="file" class="form-control-file @error('gambar') is-invalid @enderror" 
              id="gambar" name="gambar" accept="image/*">
            <small class="form-text text-muted">Maksimal 5MB. Format: JPEG, PNG, JPG, GIF. Kosongkan jika tidak ingin mengubah gambar.</small>
            @error('gambar')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="preview" class="mt-3" style="display: none;">
              <img id="previewImage" src="" alt="Preview" style="max-width: 300px; max-height: 300px;" class="img-thumbnail">
            </div>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">
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
  document.getElementById('gambar').addEventListener('change', function(e) {
    var file = e.target.files[0];
    if (file) {
      var reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('previewImage').src = e.target.result;
        document.getElementById('preview').style.display = 'block';
      }
      reader.readAsDataURL(file);
    } else {
      document.getElementById('preview').style.display = 'none';
    }
  });
</script>
@endpush

