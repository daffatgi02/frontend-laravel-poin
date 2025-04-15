@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-coins me-2"></i>Riwayat Poin</h2>
                    <p class="text-muted">Lihat riwayat poin yang Anda dapatkan dari penjualan produk.</p>
                </div>
                <a href="{{ route('toko.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-wallet me-2"></i>Saldo Poin</h5>
                </div>
                <div class="card-body text-center">
                    <div class="display-4 fw-bold text-primary mb-3">{{ number_format($totalPoints) }}</div>
                    <p class="lead">Total Poin Tersedia</p>
                    <div class="alert alert-info mt-3">
                        <i class="fas fa-info-circle me-2"></i>Poin ini akan bertambah setiap kali penjualan Anda diverifikasi oleh admin.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Transaksi Poin</h5>
                </div>
                <div class="card-body p-0">
                    @if ($points->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Deskripsi</th>
                                        <th>Tipe</th>
                                        <th class="text-end">Poin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($points as $point)
                                    <tr>
                                        <td>{{ $point->created_at->format('d M Y H:i') }}</td>
                                        <td>{{ $point->description }}</td>
                                        <td>
                                            @if ($point->type == 'earned')
                                                <span class="badge bg-success">Earned</span>
                                            @else
                                                <span class="badge bg-warning">Redeemed</span>
                                            @endif
                                        </td>
                                        <td class="text-end fw-bold {{ $point->type == 'earned' ? 'text-success' : 'text-danger' }}">
                                            {{ $point->type == 'earned' ? '+' : '-' }}{{ number_format($point->points) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-coins fa-4x text-muted mb-3"></i>
                            <h4>Belum ada riwayat poin</h4>
                            <p class="text-muted">Riwayat poin akan muncul saat Anda melakukan penjualan dan diverifikasi oleh admin.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
