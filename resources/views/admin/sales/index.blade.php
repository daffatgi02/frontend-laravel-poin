@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-shopping-cart me-2"></i>Verifikasi Penjualan</h2>
                    <p class="text-muted">Kelola dan verifikasi catatan penjualan dari toko.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
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

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-primary text-white"><i class="fas fa-search"></i></span>
                        <input type="text" id="searchInput" class="form-control" placeholder="Cari penjualan...">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        <select id="statusFilter" class="form-select me-2" style="max-width: 200px;">
                            <option value="all">Semua Status</option>
                            <option value="pending">Menunggu Verifikasi</option>
                            <option value="verified">Terverifikasi</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if ($sales->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0" id="salesTable">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Toko</th>
                                <th scope="col">Produk</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Total</th>
                                <th scope="col">Tanggal Penjualan</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                            <tr class="sale-row" data-status="{{ $sale->status }}">
                                <td>{{ $sale->id_penjualan }}</td>
                                <td>{{ $sale->store->nama_toko }}</td>
                                <td>{{ $sale->product->nama_produk }}</td>
                                <td>{{ $sale->jumlah }}</td>
                                <td>Rp {{ number_format($sale->jumlah * $sale->harga_jual, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($sale->tanggal_penjualan)->format('d M Y') }}</td>
                                <td>
                                    @if ($sale->status == 'pending')
                                        <span class="badge bg-warning">Menunggu Verifikasi</span>
                                    @elseif ($sale->status == 'verified')
                                        <span class="badge bg-success">Terverifikasi</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.sales.show', $sale->id_penjualan) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                    <h4>Belum ada catatan penjualan</h4>
                    <p class="text-muted">Penjualan akan muncul saat toko mencatat penjualan mereka.</p>
                </div>
            @endif
        </div>
        @if ($sales->count() > 0)
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted">Menampilkan <span id="visibleCount">{{ $sales->count() }}</span> dari {{ $sales->count() }} penjualan</span>
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
        const statusFilter = document.getElementById('statusFilter');
        const saleRows = document.querySelectorAll('.sale-row');
        const visibleCount = document.getElementById('visibleCount');

        function filterSales() {
            const searchText = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;
            let count = 0;

            saleRows.forEach(function(row) {
                const storeText = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const productText = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const saleStatus = row.getAttribute('data-status');

                const matchesSearch = storeText.includes(searchText) || productText.includes(searchText);
                const matchesStatus = statusValue === 'all' || saleStatus === statusValue;

                if (matchesSearch && matchesStatus) {
                    row.style.display = '';
                    count++;
                } else {
                    row.style.display = 'none';
                }
            });

            visibleCount.textContent = count;
        }

        searchInput.addEventListener('keyup', filterSales);
        statusFilter.addEventListener('change', filterSales);
    });
</script>
@endsection
@endsection
