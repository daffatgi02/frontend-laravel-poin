@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-4">
            <h2><i class="fas fa-tachometer-alt me-2"></i>Dashboard Toko</h2>
            <p class="text-muted">Kelola toko dan lihat informasi penting di sini.</p>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i>{{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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

    @if (!$store)
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-body text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/1376/1376544.png" alt="Store Icon" style="width: 100px; margin-bottom: 20px;">
                        <h3>Anda belum memiliki toko</h3>
                        <p class="text-muted mb-4">Untuk mulai menggunakan aplikasi ini, silakan buat toko terlebih dahulu.</p>
                        <a href="{{ route('toko.create_store') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus-circle me-1"></i>Buat Toko
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Status Toko</h5>
                    </div>
                    <div class="card-body text-center">
                        @if ($store->status == 'pending')
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <div class="spinner-border text-warning me-2" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <h4 class="text-warning mb-0">Menunggu Verifikasi</h4>
                            </div>
                            <p>Toko Anda sedang dalam proses verifikasi oleh Admin. Harap bersabar.</p>
                        @elseif ($store->status == 'verified')
                            <div class="mb-3">
                                <i class="fas fa-check-circle text-success fa-5x"></i>
                            </div>
                            <h4 class="text-success">Terverifikasi</h4>
                            <p>Toko Anda telah diverifikasi dan aktif. Anda dapat mulai mengelola produk.</p>
                        @else
                            <div class="mb-3">
                                <i class="fas fa-times-circle text-danger fa-5x"></i>
                            </div>
                            <h4 class="text-danger">Nonaktif</h4>
                            <p>Toko Anda saat ini tidak aktif. Silahkan hubungi admin untuk informasi lebih lanjut.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-8 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-store me-2"></i>Informasi Toko</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <th><i class="fas fa-store me-2"></i>Nama Toko</th>
                                        <td>{{ $store->nama_toko }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-map-marker-alt me-2"></i>Alamat</th>
                                        <td>{{ $store->alamat }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-user me-2"></i>Nama Pemilik</th>
                                        <td>{{ $store->nama_pemilik }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-phone me-2"></i>No. HP</th>
                                        <td>{{ $store->no_hp }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <div id="storePhotosCarousel" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="{{ asset('storage/' . $store->foto1) }}" class="d-block w-100 rounded" alt="Foto Toko 1" style="height: 200px; object-fit: cover;">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{ asset('storage/' . $store->foto2) }}" class="d-block w-100 rounded" alt="Foto Toko 2" style="height: 200px; object-fit: cover;">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{ asset('storage/' . $store->foto3) }}" class="d-block w-100 rounded" alt="Foto Toko 3" style="height: 200px; object-fit: cover;">
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#storePhotosCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#storePhotosCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        @if ($store->status == 'verified')
                            <a href="{{ route('toko.products') }}" class="btn btn-primary">
                                <i class="fas fa-boxes me-1"></i>Lihat Produk
                            </a>
                        @endif
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card dashboard-card bg-light h-100">
                            <div class="card-body text-center p-4">
                                <i class="fas fa-shopping-cart fa-3x text-primary mb-3"></i>
                                <h5>Catat Penjualan</h5>
                                <p>Catat penjualan produk Anda dan dapatkan poin reward.</p>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('toko.sales.index') }}" class="btn btn-primary">
                                        <i class="fas fa-shopping-cart me-1"></i>Kelola Penjualan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($store->status == 'verified')
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Fitur Toko</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card dashboard-card bg-light h-100">
                                    <div class="card-body text-center p-4">
                                        <i class="fas fa-boxes fa-3x text-primary mb-3"></i>
                                        <h5>Lihat Produk</h5>
                                        <p>Lihat semua produk yang tersedia di toko Anda.</p>
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('toko.products') }}" class="btn btn-primary">
                                                <i class="fas fa-boxes me-1"></i>Lihat Produk
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card dashboard-card bg-light h-100">
                                    <div class="card-body text-center p-4">
                                        <i class="fas fa-info-circle fa-3x text-info mb-3"></i>
                                        <h5>Informasi</h5>
                                        <p>Produk toko Anda dikelola oleh admin. Silakan hubungi admin untuk menambah atau mengubah produk.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if ($store->status == 'verified')
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Ringkasan Toko</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card dashboard-card bg-light">
                                    <div class="card-body text-center">
                                        <i class="fas fa-boxes fa-3x text-primary mb-3"></i>
                                        <h5>Total Produk</h5>
                                        <h3>{{ $store->products->count() }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card dashboard-card bg-light">
                                    <div class="card-body text-center">
                                        <i class="fas fa-calendar-alt fa-3x text-success mb-3"></i>
                                        <h5>Tanggal Diverifikasi</h5>
                                        <h3>{{ $store->updated_at->format('d M Y') }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card dashboard-card bg-light">
                                    <div class="card-body text-center">
                                        <i class="fas fa-trophy fa-3x text-warning mb-3"></i>
                                        <h5>Status</h5>
                                        <h3><span class="badge bg-success">Aktif</span></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif
</div>
@endsection
