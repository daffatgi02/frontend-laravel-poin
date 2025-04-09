@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2><i class="fas fa-box me-2"></i>Detail Produk</h2>
                        <p class="text-muted">Lihat informasi lengkap produk.</p>
                    </div>
                    @if (auth()->user()->role === 'Admin')
                        <div>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar Produk
                            </a>
                        </div>
                    @else
                        <div>
                            <a href="{{ route('toko.products') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar Produk
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-image me-2"></i>Foto Produk</h5>
                    </div>
                    <div class="card-body text-center">
                        @if ($product->foto_produk)
                            <img src="{{ asset('storage/' . $product->foto_produk) }}" alt="{{ $product->nama_produk }}"
                                class="img-fluid rounded mb-3" style="max-height: 300px;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center p-5 rounded mb-3">
                                <i class="fas fa-image fa-5x text-secondary"></i>
                            </div>
                        @endif

                        <h4>{{ $product->nama_produk }}</h4>
                        <p class="text-muted">ID: {{ $product->id_produk }}</p>

                        <div class="d-flex justify-content-between mt-3">
                            <span class="badge bg-primary p-2">
                                <i class="fas fa-tag me-1"></i><span class="badge bg-primary p-2">
                                    <i class="fas fa-tag me-1"></i>Rp {{ number_format($product->harga, 0, ',', '.') }}
                                </span>
                                <span class="badge bg-success p-2">
                                    <i class="fas fa-box me-1"></i>Stok: {{ $product->stok }}
                                </span>
                                <span class="badge bg-info text-white p-2">
                                    <i class="fas fa-award me-1"></i>{{ number_format($product->reward_poin) }} Poin
                                </span>
                        </div>
                    </div>
                    @if (auth()->user()->role === 'Admin')
                        <div class="card-footer bg-white">
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.products.edit', $product->id_produk) }}"
                                    class="btn btn-warning text-white w-50">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                <button type="button" class="btn btn-danger w-50" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal">
                                    <i class="fas fa-trash me-1"></i>Hapus
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-8 mb-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Produk</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">Deskripsi</h5>
                            <p class="mb-0">{{ $product->deskripsi ?: 'Tidak ada deskripsi' }}</p>
                        </div>

                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">Detail</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <th style="width: 40%">ID Produk</th>
                                            <td>{{ $product->id_produk }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Produk</th>
                                            <td>{{ $product->nama_produk }}</td>
                                        </tr>
                                        <tr>
                                            <th>Harga</th>
                                            <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Stok</th>
                                            <td>{{ $product->stok }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <th style="width: 40%">Reward Poin</th>
                                            <td>{{ number_format($product->reward_poin) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Dibuat</th>
                                            <td>{{ $product->created_at->format('d M Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Terakhir Diupdate</th>
                                            <td>{{ $product->updated_at->format('d M Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-store me-2"></i>Informasi Toko</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            @if ($product->store->foto1)
                                <img src="{{ asset('storage/' . $product->store->foto1) }}"
                                    alt="{{ $product->store->nama_toko }}" class="rounded me-3"
                                    style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center me-3 rounded"
                                    style="width: 80px; height: 80px;">
                                    <i class="fas fa-store fa-2x text-secondary"></i>
                                </div>
                            @endif

                            <div>
                                <h5 class="mb-1">{{ $product->store->nama_toko }}</h5>
                                <p class="text-muted mb-0">{{ $product->store->alamat }}</p>
                                <div class="mt-2">
                                    <span
                                        class="badge bg-{{ $product->store->status == 'verified' ? 'success' : ($product->store->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ $product->store->status == 'verified' ? 'Terverifikasi' : ($product->store->status == 'pending' ? 'Menunggu Verifikasi' : 'Nonaktif') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <th style="width: 40%">Pemilik</th>
                                            <td>{{ $product->store->nama_pemilik }}</td>
                                        </tr>
                                        <tr>
                                            <th>No. HP</th>
                                            <td>{{ $product->store->no_hp }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <th style="width: 40%">Email</th>
                                            <td>{{ $product->store->user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>ID Toko</th>
                                            <td>{{ $product->store->id_toko }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        @if (auth()->user()->role === 'Admin')
                            <div class="mt-3">
                                <a href="{{ route('admin.show_store', $product->store->id_toko) }}"
                                    class="btn btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i>Lihat Detail Toko
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if (auth()->user()->role === 'Admin')
            <!-- Delete Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="deleteModalLabel">
                                <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus produk <strong>"{{ $product->nama_produk }}"</strong>?</p>
                            <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <form action="{{ route('admin.products.destroy', $product->id_produk) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-1"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
