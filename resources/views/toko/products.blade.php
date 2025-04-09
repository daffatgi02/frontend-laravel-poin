@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-boxes me-2"></i>Produk Toko</h2>
                    <p class="text-muted">Lihat dan kelola produk yang terdaftar untuk toko Anda.</p>
                </div>
                <a href="{{ route('toko.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-1"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Produk - {{ $store->nama_toko }}</h5>
        </div>
        <div class="card-body">
            @if ($products->count() > 0)
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari produk...">
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach ($products as $product)
                    <div class="col-md-4 mb-4 product-card">
                        <div class="card h-100 shadow-sm hover-shadow">
                            <div class="position-relative">
                                @if ($product->foto_produk)
                                    <img src="{{ asset('storage/' . $product->foto_produk) }}" class="card-img-top" alt="{{ $product->nama_produk }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="No Image" style="height: 200px; object-fit: cover;">
                                @endif
                                <div class="position-absolute top-0 end-0 p-2">
                                    <span class="badge bg-primary">{{ number_format($product->reward_poin) }} Poin</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title product-name">{{ $product->nama_produk }}</h5>
                                <p class="card-text text-muted small mb-2 product-description">{{ Str::limit($product->deskripsi, 80) }}</p>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="text-primary mb-0">Rp {{ number_format($product->harga, 0, ',', '.') }}</h5>
                                    <span class="badge bg-{{ $product->stok > 0 ? 'success' : 'danger' }}">
                                        {{ $product->stok > 0 ? 'Stok: ' . $product->stok : 'Habis' }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <button type="button" class="btn btn-sm btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#productModal-{{ $product->id_produk }}">
                                    <i class="fas fa-eye me-1"></i>Detail
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Detail Produk -->
                    <div class="modal fade" id="productModal-{{ $product->id_produk }}" tabindex="-1" aria-labelledby="productModalLabel-{{ $product->id_produk }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="productModalLabel-{{ $product->id_produk }}">
                                        <i class="fas fa-box me-2"></i>Detail Produk
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            @if ($product->foto_produk)
                                                <img src="{{ asset('storage/' . $product->foto_produk) }}" class="img-fluid rounded" alt="{{ $product->nama_produk }}">
                                            @else
                                                <img src="https://via.placeholder.com/400x400?text=No+Image" class="img-fluid rounded" alt="No Image">
                                            @endif
                                        </div>
                                        <div class="col-md-7">
                                            <h4>{{ $product->nama_produk }}</h4>
                                            <p class="text-muted">{{ $product->deskripsi }}</p>

                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <div class="card bg-light">
                                                        <div class="card-body text-center py-2">
                                                            <h6 class="mb-1">Harga</h6>
                                                            <h5 class="text-primary mb-0">Rp {{ number_format($product->harga, 0, ',', '.') }}</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="card bg-light">
                                                        <div class="card-body text-center py-2">
                                                            <h6 class="mb-1">Stok</h6>
                                                            <h5 class="mb-0">{{ $product->stok }}</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card bg-light mb-3">
                                                <div class="card-body text-center py-2">
                                                    <h6 class="mb-1">Reward Poin</h6>
                                                    <h5 class="text-success mb-0">{{ number_format($product->reward_poin) }} Poin</h5>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <h6>Informasi Tambahan</h6>
                                                <ul class="list-group">
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        ID Produk
                                                        <span class="badge bg-secondary rounded-pill">{{ $product->id_produk }}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        Tanggal Ditambahkan
                                                        <span>{{ $product->created_at->format('d M Y') }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    <div class="text-center py-5">
                        <i class="fas fa-box-open fa-4x mb-3 text-muted"></i>
                        <h4>Belum ada produk untuk toko ini</h4>
                        <p class="mb-0">Admin akan menambahkan produk untuk toko Anda setelah diverifikasi.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@section('scripts')
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        var searchText = this.value.toLowerCase();
        var productCards = document.querySelectorAll('.product-card');

        productCards.forEach(function(card) {
            var productName = card.querySelector('.product-name').innerText.toLowerCase();
            var productDescription = card.querySelector('.product-description').innerText.toLowerCase();

            if (productName.includes(searchText) || productDescription.includes(searchText)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>
@endsection
@endsection
