@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-4">
            <h2><i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin</h2>
            <p class="text-muted">Kelola dan pantau toko-toko yang terdaftar di sistem.</p>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i>{{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card dashboard-card border-0 shadow-sm bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase">Total Toko</h6>
                            <h2 class="display-4 mb-0">{{ $storeCount }}</h2>
                        </div>
                        <i class="fas fa-store fa-3x opacity-50"></i>
                    </div>
                    <p class="mt-3 mb-0">Semua toko yang terdaftar dalam sistem.</p>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.stores') }}" class="text-white">Lihat Semua Toko</a>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card dashboard-card border-0 shadow-sm bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase">Menunggu Verifikasi</h6>
                            <h2 class="display-4 mb-0">{{ $pendingStores }}</h2>
                        </div>
                        <i class="fas fa-clock fa-3x opacity-50"></i>
                    </div>
                    <p class="mt-3 mb-0">Toko yang membutuhkan verifikasi dari admin.</p>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.stores') }}" class="text-white">Verifikasi Toko</a>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card dashboard-card border-0 shadow-sm bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase">Toko Terverifikasi</h6>
                            <h2 class="display-4 mb-0">{{ $verifiedStores }}</h2>
                        </div>
                        <i class="fas fa-check-circle fa-3x opacity-50"></i>
                    </div>
                    <p class="mt-3 mb-0">Toko yang sudah diverifikasi dan aktif.</p>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.stores') }}" class="text-white">Lihat Toko Aktif</a>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Tindakan Cepat</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card border-primary h-100">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-store-alt fa-3x text-primary mb-3"></i>
                                    <h5>Kelola Toko</h5>
                                    <p class="text-muted">Lihat, verifikasi, dan kelola semua toko yang terdaftar.</p>
                                    <a href="{{ route('admin.stores') }}" class="btn btn-primary mt-2">
                                        <i class="fas fa-store me-1"></i>Lihat Semua Toko
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-success h-100">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-boxes fa-3x text-success mb-3"></i>
                                    <h5>Manajemen Produk</h5>
                                    <p class="text-muted">Tambah, edit, dan hapus produk untuk toko yang terverifikasi.</p>
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-success mt-2">
                                        <i class="fas fa-boxes me-1"></i>Kelola Produk
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-info h-100">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-users fa-3x text-info mb-3"></i>
                                    <h5>Pengguna Tanpa Toko</h5>
                                    <p class="text-muted">Lihat pengguna yang belum memiliki toko terdaftar.</p>
                                    <a href="{{ route('admin.users_without_store') }}" class="btn btn-info mt-2 text-white">
                                        <i class="fas fa-users me-1"></i>Lihat Pengguna
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-warning h-100">
                <div class="card-body text-center p-4">
                    <i class="fas fa-shopping-cart fa-3x text-warning mb-3"></i>
                    <h5>Verifikasi Penjualan</h5>
                    <p class="text-muted">Verifikasi penjualan dari toko dan kelola bukti penjualan.</p>
                    <a href="{{ route('admin.sales.index') }}" class="btn btn-warning text-white mt-2">
                        <i class="fas fa-check-circle me-1"></i>Verifikasi Penjualan
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Statistik Toko</h5>
                </div>
                <div class="card-body">
                    <canvas id="storeStatusChart" height="220"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Sistem</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3 bg-light p-3 rounded">
                                    <i class="fas fa-calendar-alt text-secondary fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Tanggal</h6>
                                    <p class="mb-0 text-muted">{{ date('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3 bg-light p-3 rounded">
                                    <i class="fas fa-user-shield text-secondary fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Login Sebagai</h6>
                                    <p class="mb-0 text-muted">Admin</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart for store status
        var ctx = document.getElementById('storeStatusChart').getContext('2d');
        var storeStatusChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Terverifikasi', 'Menunggu Verifikasi', 'Nonaktif'],
                datasets: [{
                    data: [{{ $verifiedStores }}, {{ $pendingStores }}, {{ $storeCount - $verifiedStores - $pendingStores }}],
                    backgroundColor: [
                        '#28a745',
                        '#ffc107',
                        '#dc3545'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>
@endsection
@endsection
