@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-edit me-2"></i>Edit Produk</h2>
                    <p class="text-muted">Perbarui informasi produk.</p>
                </div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar Produk
                </a>
            </div>
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-1"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-box me-2"></i>Edit Produk: {{ $product->nama_produk }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product->id_produk) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="store_id" class="form-label">Pilih Toko <span class="text-danger">*</span></label>
                        <select class="form-select @error('store_id') is-invalid @enderror" id="store_id" name="store_id" required>
                            <option value="">-- Pilih Toko --</option>
                            @foreach($stores as $store)
                                <option value="{{ $store->id_toko }}" {{ old('store_id', $product->store_id) == $store->id_toko ? 'selected' : '' }}>
                                    {{ $store->nama_toko }} ({{ $store->nama_pemilik }})
                                </option>
                            @endforeach
                        </select>
                        @error('store_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">Hanya toko yang terverifikasi yang ditampilkan.</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" required>
                        @error('nama_produk')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Produk</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="harga" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga', $product->harga) }}" required min="0">
                        </div>
                        @error('harga')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok" name="stok" value="{{ old('stok', $product->stok) }}" required min="0">
                        @error('stok')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="reward_poin" class="form-label">Reward Poin <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('reward_poin') is-invalid @enderror" id="reward_poin" name="reward_poin" value="{{ old('reward_poin', $product->reward_poin) }}" required min="0">
                        @error('reward_poin')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="foto_produk" class="form-label">Foto Produk</label>
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="file" class="form-control @error('foto_produk') is-invalid @enderror" id="foto_produk" name="foto_produk" accept="image/jpeg,image/png,image/jpg" onchange="previewImage(this)">
                                    @error('foto_produk')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="form-text">Upload gambar baru untuk mengganti foto yang ada (opsional). Format: JPG, JPEG, atau PNG. Maksimal 2MB.</div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <img id="preview" src="{{ $product->foto_produk ? asset('storage/' . $product->foto_produk) : 'https://placehold.co/150?text=No+Image' }}" class="img-fluid rounded" alt="Preview" style="max-height: 150px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary me-md-2">
                        <i class="fas fa-times me-1"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
@endsection
