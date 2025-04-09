@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-plus-circle me-2"></i>Buat Toko Baru</h2>
                    <p class="text-muted">Lengkapi informasi toko Anda untuk mulai menggunakan aplikasi.</p>
                </div>
                <a href="{{ route('toko.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-store me-2"></i>Formulir Pendaftaran Toko</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('toko.store_store') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-info-circle me-2"></i>Informasi Dasar</h5>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nama_toko" class="form-label">Nama Toko <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-store"></i></span>
                                    <input id="nama_toko" type="text" class="form-control @error('nama_toko') is-invalid @enderror" name="nama_toko" value="{{ old('nama_toko') }}" required autocomplete="nama_toko" autofocus placeholder="Masukkan nama toko">
                                </div>
                                @error('nama_toko')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text">Nama toko akan ditampilkan kepada admin dan pengguna lain.</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nama_pemilik" class="form-label">Nama Pemilik <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input id="nama_pemilik" type="text" class="form-control @error('nama_pemilik') is-invalid @enderror" name="nama_pemilik" value="{{ old('nama_pemilik') }}" required autocomplete="nama_pemilik" placeholder="Masukkan nama pemilik">
                                </div>
                                @error('nama_pemilik')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="no_hp" class="form-label">Nomor HP <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input id="no_hp" type="text" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" value="{{ old('no_hp') }}" required autocomplete="no_hp" placeholder="Contoh: 081234567890">
                                </div>
                                @error('no_hp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="alamat" class="form-label">Alamat Toko <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" rows="3" required placeholder="Masukkan alamat lengkap toko">{{ old('alamat') }}</textarea>
                                </div>
                                @error('alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-image me-2"></i>Foto Toko (Wajib 3 Foto)</h5>
                                <p class="text-muted small">Upload foto toko Anda yang jelas. Format yang didukung: JPG, JPEG, PNG. Maksimal 2MB per foto.</p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="foto1" class="form-label">Foto 1 (Depan Toko) <span class="text-danger">*</span></label>
                                <div class="card">
                                    <div class="card-body text-center p-3">
                                        <div class="mb-3">
                                            <img id="preview1" src="https://via.placeholder.com/150?text=Foto+1" class="img-fluid rounded mb-2" alt="Preview Foto 1" style="max-height: 150px;">
                                        </div>
                                        <div class="input-group">
                                            <input id="foto1" type="file" class="form-control @error('foto1') is-invalid @enderror" name="foto1" required accept="image/jpeg,image/png,image/jpg" onchange="previewImage(this, 'preview1')">
                                        </div>
                                        @error('foto1')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="foto2" class="form-label">Foto 2 (Interior) <span class="text-danger">*</span></label>
                                <div class="card">
                                    <div class="card-body text-center p-3">
                                        <div class="mb-3">
                                            <img id="preview2" src="https://via.placeholder.com/150?text=Foto+2" class="img-fluid rounded mb-2" alt="Preview Foto 2" style="max-height: 150px;">
                                        </div>
                                        <div class="input-group">
                                            <input id="foto2" type="file" class="form-control @error('foto2') is-invalid @enderror" name="foto2" required accept="image/jpeg,image/png,image/jpg" onchange="previewImage(this, 'preview2')">
                                        </div>
                                        @error('foto2')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="foto3" class="form-label">Foto 3 (Produk) <span class="text-danger">*</span></label>
                                <div class="card">
                                    <div class="card-body text-center p-3">
                                        <div class="mb-3">
                                            <img id="preview3" src="https://via.placeholder.com/150?text=Foto+3" class="img-fluid rounded mb-2" alt="Preview Foto 3" style="max-height: 150px;">
                                        </div>
                                        <div class="input-group">
                                            <input id="foto3" type="file" class="form-control @error('foto3') is-invalid @enderror" name="foto3" required accept="image/jpeg,image/png,image/jpg" onchange="previewImage(this, 'preview3')">
                                        </div>
                                        @error('foto3')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-end">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>Toko Anda akan menunggu verifikasi dari Admin setelah pendaftaran.
                                </div>
                                <a href="{{ route('toko.dashboard') }}" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-times me-1"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Daftarkan Toko
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
@endsection
