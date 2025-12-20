@extends('admin.layout')

@section('title', 'Edit User - Admin Donasi PMI')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item">User</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Data User</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
  </ol>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit User</h6>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
          @csrf
          @method('PUT')
          
          <div class="form-group">
            <label for="name">Nama <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
              id="name" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control @error('username') is-invalid @enderror" 
              id="username" name="username" value="{{ old('username', $user->username) }}">
            <small class="form-text text-muted">Kosongkan jika tidak ingin menggunakan username</small>
            @error('username')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
              id="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" 
              id="password" name="password">
            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password. Minimal 6 karakter jika diisi.</small>
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" class="form-control" 
              id="password_confirmation" name="password_confirmation">
            <small class="form-text text-muted">Wajib diisi jika mengubah password</small>
          </div>

          <div class="form-group">
            <label for="hak_aksis">Hak Akses <span class="text-danger">*</span></label>
            <select class="form-control @error('hak_aksis') is-invalid @enderror" 
              id="hak_aksis" name="hak_aksis" required>
              <option value="">-- Pilih Hak Akses --</option>
              <option value="superadmin" {{ old('hak_aksis', $user->hak_aksis) == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
              <option value="admin" {{ old('hak_aksis', $user->hak_aksis) == 'admin' ? 'selected' : '' }}>Admin</option>
              <option value="user" {{ old('hak_aksis', $user->hak_aksis) == 'user' ? 'selected' : '' }}>User</option>
            </select>
            @error('hak_aksis')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          @if($user->last_login)
          <div class="form-group">
            <label>Last Login</label>
            <input type="text" class="form-control" value="{{ $user->last_login->format('d/m/Y H:i:s') }}" readonly>
          </div>
          @endif

          <div class="form-group">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">
              <i class="fas fa-times"></i> Batal
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

