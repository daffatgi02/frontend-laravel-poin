@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-receipt me-2"></i>Detail Penjualan</h2>
                    <p class="text-muted">Lihat informasi lengkap penjualan.</p>
                </div>
                <a href="{{ route('toko.sales.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar Penjualan
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Penjualan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="border-bottom pb-2 mb-3">Data Penjualan</h5>

                            <div class="mb-3">
                                <label class="form-label text-muted">ID Penjualan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                    <input type="text" class="form-control" value="{{ $sale->id_penjualan }}" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Tanggal Penjualan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($sale->tanggal_penjualan)->format('d M Y') }}" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Status</label>
                                <div>
                                    @if ($sale->status == 'pending')
                                        <span class="badge bg-warning p-2"><i class="fas fa-clock me-1"></i>Menunggu Verifikasi</span>
                                    @elseif ($sale->status == 'verified')
                                        <span class="badge bg-success p-2"><i class="fas fa-check-circle me-1"></i>Terverifikasi</span>
                                    @else
                                        <span class="badge bg-danger p-2"><i class="fas fa-times-circle me-1"></i>Ditolak</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h5 class="border-bottom pb-2 mb-3">Detail Produk</h5>

                            <div class="mb-3">
                                <label class="form-label text-muted">Nama Produk</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-box"></i></span>
                                    <input type="text" class="form-control" value="{{ $sale->product->nama_produk }}" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Jumlah</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-sort-numeric-up"></i></span>
                                    <input type="text" class="form-control" value="{{ $sale->jumlah }}" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Harga Jual</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <input type="text" class="form-control" value="Rp {{ number_format($sale->harga_jual, 0, ',', '.') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">Total Penjualan</h5>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-1">Jumlah Item:</p>
                                            <h5>{{ $sale->jumlah }} pcs</h5>
                                        </div>
                                        <div class="col-md-6 text-md-end">
                                            <p class="mb-1">Total Harga:</p>
                                            <h5 class="text-primary">Rp {{ number_format($sale->jumlah * $sale->harga_jual, 0, ',', '.') }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($sale->catatan)
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">Catatan</h5>
                            <p>{{ $sale->catatan }}</p>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Dibuat pada: {{ $sale->created_at->format('d M Y H:i') }}</span>
                        <a href="{{ route('toko.sales.pdf', $sale->id_penjualan) }}" class="btn btn-primary" target="_blank">
                            <i class="fas fa-file-pdf me-1"></i>Download PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-image me-2"></i>Bukti Penjualan</h5>
                </div>
                <div class="card-body text-center">
                    @if ($sale->bukti_penjualan)
                        <img src="{{ asset('storage/' . $sale->bukti_penjualan) }}" class="img-fluid rounded" alt="Bukti Penjualan">
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-1"></i>Bukti penjualan tidak tersedia.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
