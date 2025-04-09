@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-receipt me-2"></i>Detail & Verifikasi Penjualan</h2>
                    <p class="text-muted">Lihat dan verifikasi penjualan dari toko.</p>
                </div>
                <div>
                    <a href="{{ route('admin.sales.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar Penjualan
                    </a>
                    <a href="{{ route('admin.sales.pdf', $sale->id_penjualan) }}" class="btn btn-primary" target="_blank">
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
                            <h5 class="border-bottom pb-2 mb-3">Informasi Toko</h5>

                            <div class="mb-3">
                                <label class="form-label text-muted">Nama Toko</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-store"></i></span>
                                    <input type="text" class="form-control" value="{{ $sale->store->nama_toko }}" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Pemilik</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" value="{{ $sale->store->nama_pemilik }}" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Alamat</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <textarea class="form-control" readonly rows="2">{{ $sale->store->alamat }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">Detail Produk</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Produk</th>
                                            <th>Jumlah</th>
                                            <th>Harga Satuan</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if ($sale->product->foto_produk)
                                                        <img src="{{ asset('storage/' . $sale->product->foto_produk) }}" class="rounded me-2" alt="Foto Produk" style="width: 40px; height: 40px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light me-2 rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                            <i class="fas fa-box text-secondary"></i>
                                                        </div>
                                                    @endif
                                                    <span>{{ $sale->product->nama_produk }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $sale->jumlah }}</td>
                                            <td>Rp {{ number_format($sale->harga_jual, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($sale->jumlah * $sale->harga_jual, 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <td colspan="3" class="text-end fw-bold">Total:</td>
                                            <td class="fw-bold">Rp {{ number_format($sale->jumlah * $sale->harga_jual, 0, ',', '.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if ($sale->catatan)
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">Catatan Toko</h5>
                            <p>{{ $sale->catatan }}</p>
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
                    <h5 class="mb-0"><i class="fas fa-check-circle me-2"></i>Verifikasi Penjualan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.sales.update_status', $sale->id_penjualan) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="status" class="form-label">Status Penjualan</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="pending" {{ $sale->status == 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                <option value="verified" {{ $sale->status == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                                <option value="rejected" {{ $sale->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="catatan_admin" class="form-label">Catatan Admin</label>
                            <textarea class="form-control @error('catatan_admin') is-invalid @enderror" id="catatan_admin" name="catatan_admin" rows="3">{{ old('catatan_admin', $sale->catatan_admin) }}</textarea>
                            @error('catatan_admin')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Perbarui Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bukti Penjualan -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-images me-2"></i>Bukti Penjualan</h5>
                </div>
                <div class="card-body">
                    <div id="buktiCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @if ($sale->bukti_penjualan && is_array(json_decode($sale->bukti_penjualan)))
                                @foreach(json_decode($sale->bukti_penjualan) as $index => $foto)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $foto) }}" class="d-block w-100 rounded" alt="Bukti Penjualan {{ $index + 1 }}" style="max-height: 300px; object-fit: contain;">
                                        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                                            <h6>Bukti {{ $index + 1 }}</h6>
                                        </div>
                                    </div>
                                @endforeach
                            @elseif ($sale->bukti_penjualan)
                                <div class="carousel-item active">
                                    <img src="{{ asset('storage/' . $sale->bukti_penjualan) }}" class="d-block w-100 rounded" alt="Bukti Penjualan" style="max-height: 300px; object-fit: contain;">
                                </div>
                            @else
                                <div class="carousel-item active">
                                    <div class="d-flex justify-content-center align-items-center bg-light rounded" style="height: 200px;">
                                        <span class="text-muted">Tidak ada bukti penjualan</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if (($sale->bukti_penjualan && is_array(json_decode($sale->bukti_penjualan)) && count(json_decode($sale->bukti_penjualan)) > 1) ||
                            ($sale->bukti_penjualan && !is_array(json_decode($sale->bukti_penjualan, true))))
                            <button class="carousel-control-prev" type="button" data-bs-target="#buktiCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#buktiCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        @endif
                    </div>

                    <div class="mt-3 text-center">
                        <p class="text-muted small">Klik pada gambar untuk melihat ukuran penuh</p>
                        <div class="d-flex flex-wrap justify-content-center">
                            @if ($sale->bukti_penjualan && is_array(json_decode($sale->bukti_penjualan)))
                                @foreach(json_decode($sale->bukti_penjualan) as $index => $foto)
                                    <a href="{{ asset('storage/' . $foto) }}" target="_blank" class="m-1">
                                        <img src="{{ asset('storage/' . $foto) }}" alt="Thumbnail {{ $index + 1 }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                    </a>
                                @endforeach
                            @elseif ($sale->bukti_penjualan)
                                <a href="{{ asset('storage/' . $sale->bukti_penjualan) }}" target="_blank" class="m-1">
                                    <img src="{{ asset('storage/' . $sale->bukti_penjualan) }}" alt="Thumbnail" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
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
