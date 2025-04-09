@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-boxes me-2"></i>Daftar Produk</h2>
                    <p class="text-muted">Kelola semua produk yang terdaftar dalam sistem.</p>
                </div>
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-1"></i>Kembali ke Dashboard
                    </a>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i>Tambah Produk
                    </a>
                </div>
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
        <div class="card-header bg-white">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-primary text-white"><i class="fas fa-search"></i></span>
                        <input type="text" id="searchInput" class="form-control" placeholder="Cari produk berdasarkan nama...">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        <select id="storeFilter" class="form-select me-2" style="max-width: 200px;">
                            <option value="all">Semua Toko</option>
                            @foreach(\App\Models\Store::where('status', 'verified')->get() as $store)
                                <option value="{{ $store->id_toko }}">{{ $store->nama_toko }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if ($products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0" id="productsTable">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Foto</th>
                                <th scope="col">Nama Produk</th>
                                <th scope="col">Toko</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Reward Poin</th>
                                <th scope="col" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr class="product-row" data-store="{{ $product->store_id }}">
                                <td>{{ $product->id_produk }}</td>
                                <td>
                                    @if ($product->foto_produk)
                                        <img src="{{ asset('storage/' . $product->foto_produk) }}" alt="{{ $product->nama_produk }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-image text-secondary"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $product->nama_produk }}</td>
                                <td>{{ $product->store->nama_toko }}</td>
                                <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $product->stok - $product->reserved_stock > 0 ? 'success' : 'danger' }}">
                                        {{ $product->stok - $product->reserved_stock > 0 ? 'Tersedia: ' . ($product->stok - $product->reserved_stock) : 'Habis' }}
                                    </span>
                                    <br>
                                    <small class="text-muted">Total: {{ $product->stok }} | Dipesan: {{ $product->reserved_stock }}</small>
                                </td>
                                <td>{{ number_format($product->reward_poin) }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.products.show', $product->id_produk) }}" class="btn btn-sm btn-info text-white">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product->id_produk) }}" class="btn btn-sm btn-warning text-white">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $product->id_produk }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal-{{ $product->id_produk }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $product->id_produk }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="deleteModalLabel-{{ $product->id_produk }}">
                                                        <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                    <h4>Belum ada produk yang terdaftar</h4>
                    <p class="text-muted">Mulai tambahkan produk untuk toko-toko yang terverifikasi.</p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus-circle me-1"></i>Tambah Produk Pertama
                    </a>
                </div>
            @endif
        </div>
        @if ($products->count() > 0)
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted">Menampilkan <span id="visibleCount">{{ $products->count() }}</span> dari {{ $products->count() }} produk</span>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const storeFilter = document.getElementById('storeFilter');
        const productRows = document.querySelectorAll('.product-row');
        const visibleCount = document.getElementById('visibleCount');

        function filterProducts() {
            const searchText = searchInput.value.toLowerCase();
            const storeValue = storeFilter.value;
            let count = 0;

            productRows.forEach(function(row) {
                const productName = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const storeId = row.getAttribute('data-store');

                const matchesSearch = productName.includes(searchText);
                const matchesStore = storeValue === 'all' || storeId === storeValue;

                if (matchesSearch && matchesStore) {
                    row.style.display = '';
                    count++;
                } else {
                    row.style.display = 'none';
                }
            });

            visibleCount.textContent = count;
        }

        searchInput.addEventListener('keyup', filterProducts);
        storeFilter.addEventListener('change', filterProducts);
    });
</script>
@endsection
@endsection
