@extends('admin.layout')

@section('title', 'Tambah Pengeluaran - Admin Donasi PMI')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Tambah Pengeluaran</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item">Donasi</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.donasi.pengeluaran.index') }}">Pengeluaran</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
  </ol>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Pengeluaran</h6>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.donasi.pengeluaran.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          
          <div class="form-group">
            <label for="nama_kegiatan">Nama Kegiatan <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror" 
              id="nama_kegiatan" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" required>
            @error('nama_kegiatan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="rincian">Rincian <span class="text-danger">*</span></label>
            <textarea class="form-control @error('rincian') is-invalid @enderror" 
              id="rincian" name="rincian" rows="5" required>{{ old('rincian') }}</textarea>
            @error('rincian')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="besar_anggaran">Besar Anggaran <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('besar_anggaran') is-invalid @enderror" 
              id="besar_anggaran" name="besar_anggaran" value="{{ old('besar_anggaran') }}" 
              min="0" step="0.01" required>
            @error('besar_anggaran')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="penanggung_jawab">Penanggung Jawab <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('penanggung_jawab') is-invalid @enderror" 
              id="penanggung_jawab" name="penanggung_jawab" value="{{ old('penanggung_jawab') }}" required>
            @error('penanggung_jawab')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="file">File (PDF, DOC, DOCX, XLS, XLSX)</label>
            <input type="file" class="form-control-file @error('file') is-invalid @enderror" 
              id="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx">
            <small class="form-text text-muted">Maksimal 10MB</small>
            @error('file')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="foto">Foto</label>
            <input type="file" class="form-control-file @error('foto') is-invalid @enderror" 
              id="foto" name="foto" accept="image/*">
            <small class="form-text text-muted">Maksimal 5MB. Format: JPEG, PNG, JPG, GIF</small>
            @error('foto')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('admin.donasi.pengeluaran.index') }}" class="btn btn-secondary">
              <i class="fas fa-times"></i> Batal
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

