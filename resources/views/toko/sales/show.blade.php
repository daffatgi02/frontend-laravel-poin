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
                    <div>
                        <a href="{{ route('toko.sales.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar Penjualan
                        </a>
                        <a href="{{ route('toko.sales.pdf', $sale->id_penjualan) }}" class="btn btn-primary" target="_blank">
                            <i class="fas fa-file-pdf me-1"></i>Download PDF
                        </a>
                    </div>
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
                                        <input type="text" class="form-control" value="{{ $sale->id_penjualan }}"
                                            readonly>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label text-muted">Tanggal Penjualan</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="text" class="form-control"
                                            value="{{ \Carbon\Carbon::parse($sale->tanggal_penjualan)->format('d M Y') }}"
                                            readonly>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label text-muted">Status</label>
                                    <div>
                                        @if ($sale->status == 'pending')
                                            <span class="badge bg-warning p-2"><i class="fas fa-clock me-1"></i>Menunggu
                                                Verifikasi</span>
                                        @elseif ($sale->status == 'verified')
                                            <span class="badge bg-success p-2"><i
                                                    class="fas fa-check-circle me-1"></i>Terverifikasi</span>
                                        @else
                                            <span class="badge bg-danger p-2"><i
                                                    class="fas fa-times-circle me-1"></i>Ditolak</span>
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
                                        <input type="text" class="form-control" value="{{ $sale->product->nama_produk }}"
                                            readonly>
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
                                        <input type="text" class="form-control"
                                            value="Rp {{ number_format($sale->harga_jual, 0, ',', '.') }}" readonly>
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
                                                <h5 class="text-primary">Rp
                                                    {{ number_format($sale->jumlah * $sale->harga_jual, 0, ',', '.') }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Add this to the card at the top of the sale information -->
                        @if ($sale->status == 'verified')
                            @php
                                $pointsEarned = $sale->product->reward_poin * $sale->jumlah;
                            @endphp
                            <div class="alert alert-success mt-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-coins fa-2x me-3"></i>
                                    <div>
                                        <h5 class="mb-0">Poin Diterima</h5>
                                        <p class="mb-0">Anda mendapatkan <strong>{{ number_format($pointsEarned) }}
                                                poin</strong> dari penjualan ini.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($sale->catatan)
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 mb-3">Catatan</h5>
                                    <p>{{ $sale->catatan }}</p>
                                </div>
                            </div>
                        @endif

                        @if ($sale->catatan_admin)
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 mb-3">Catatan Admin</h5>
                                    <div
                                        class="alert {{ $sale->status == 'verified' ? 'alert-success' : ($sale->status == 'rejected' ? 'alert-danger' : 'alert-info') }}">
                                        {{ $sale->catatan_admin }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Dibuat pada: {{ $sale->created_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-images me-2"></i>Bukti Penjualan</h5>
                    </div>
                    <div class="card-body">
                        <div id="buktiCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @if ($sale->bukti_penjualan && is_array(json_decode($sale->bukti_penjualan)))
                                    @foreach (json_decode($sale->bukti_penjualan) as $index => $foto)
                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $foto) }}" class="d-block w-100 rounded"
                                                alt="Bukti Penjualan {{ $index + 1 }}"
                                                style="max-height: 300px; object-fit: contain;">
                                            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                                                <h6>Bukti {{ $index + 1 }}</h6>
                                            </div>
                                        </div>
                                    @endforeach
                                @elseif ($sale->bukti_penjualan)
                                    <div class="carousel-item active">
                                        <img src="{{ asset('storage/' . $sale->bukti_penjualan) }}"
                                            class="d-block w-100 rounded" alt="Bukti Penjualan"
                                            style="max-height: 300px; object-fit: contain;">
                                    </div>
                                @else
                                    <div class="carousel-item active">
                                        <div class="d-flex justify-content-center align-items-center bg-light rounded"
                                            style="height: 200px;">
                                            <span class="text-muted">Tidak ada bukti penjualan</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if (
                                ($sale->bukti_penjualan &&
                                    is_array(json_decode($sale->bukti_penjualan)) &&
                                    count(json_decode($sale->bukti_penjualan)) > 1) ||
                                    ($sale->bukti_penjualan && !is_array(json_decode($sale->bukti_penjualan, true))))
                                <button class="carousel-control-prev" type="button" data-bs-target="#buktiCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#buktiCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>

                        <div class="mt-3 text-center">
                            <p class="text-muted small">Klik pada gambar untuk melihat ukuran penuh</p>
                            <div class="d-flex flex-wrap justify-content-center">
                                @if ($sale->bukti_penjualan && is_array(json_decode($sale->bukti_penjualan)))
                                    @foreach (json_decode($sale->bukti_penjualan) as $index => $foto)
                                        <a href="{{ asset('storage/' . $foto) }}" target="_blank" class="m-1">
                                            <img src="{{ asset('storage/' . $foto) }}"
                                                alt="Thumbnail {{ $index + 1 }}" class="img-thumbnail"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                        </a>
                                    @endforeach
                                @elseif ($sale->bukti_penjualan)
                                    <a href="{{ asset('storage/' . $sale->bukti_penjualan) }}" target="_blank"
                                        class="m-1">
                                        <img src="{{ asset('storage/' . $sale->bukti_penjualan) }}" alt="Thumbnail"
                                            class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
