@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-store me-2"></i>Daftar Toko</h2>
                    <p class="text-muted">Kelola semua toko yang terdaftar dalam sistem.</p>
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
                        <input type="text" id="searchInput" class="form-control" placeholder="Cari toko berdasarkan nama...">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        <select id="statusFilter" class="form-select me-2" style="max-width: 200px;">
                            <option value="all">Semua Status</option>
                            <option value="pending">Menunggu Verifikasi</option>
                            <option value="verified">Terverifikasi</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if ($stores->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0" id="storeTable">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nama Toko</th>
                                <th scope="col">Pemilik</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col">Tanggal Dibuat</th>
                                <th scope="col" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stores as $store)
                            <tr class="store-row" data-status="{{ $store->status }}">
                                <td>{{ $store->id_toko }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($store->foto1)
                                            <img src="{{ asset('storage/' . $store->foto1) }}" class="rounded me-2" alt="Foto Toko" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-light me-2 rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-store text-secondary"></i>
                                            </div>
                                        @endif
                                        <span>{{ $store->nama_toko }}</span>
                                    </div>
                                </td>
                                <td>{{ $store->nama_pemilik }}</td>
                                <td>{{ $store->user->email }}</td>
                                <td>
                                    @if ($store->status == 'pending')
                                        <span class="badge bg-warning">Menunggu Verifikasi</span>
                                    @elseif ($store->status == 'verified')
                                        <span class="badge bg-success">Terverifikasi</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>{{ $store->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.show_store', $store->id_toko) }}" class="btn btn-sm btn-primary">
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
                    <i class="fas fa-store-slash fa-4x text-muted mb-3"></i>
                    <h4>Belum ada toko yang terdaftar</h4>
                    <p class="text-muted">Toko akan muncul saat pengguna mendaftar dan membuat toko mereka.</p>
                </div>
            @endif
        </div>
        @if ($stores->count() > 0)
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted">Menampilkan <span id="visibleCount">{{ $stores->count() }}</span> dari {{ $stores->count() }} toko</span>
                </div>
                <a href="{{ route('admin.users_without_store') }}" class="btn btn-outline-primary">
                    <i class="fas fa-users me-1"></i>Lihat Pengguna Tanpa Toko
                </a>
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
        const storeRows = document.querySelectorAll('.store-row');
        const visibleCount = document.getElementById('visibleCount');

        function filterStores() {
            const searchText = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;
            let count = 0;

            storeRows.forEach(function(row) {
                const storeName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const storeStatus = row.getAttribute('data-status');

                const matchesSearch = storeName.includes(searchText);
                const matchesStatus = statusValue === 'all' || storeStatus === statusValue;

                if (matchesSearch && matchesStatus) {
                    row.style.display = '';
                    count++;
                } else {
                    row.style.display = 'none';
                }
            });

            visibleCount.textContent = count;
        }

        searchInput.addEventListener('keyup', filterStores);
        statusFilter.addEventListener('change', filterStores);
    });
</script>
@endsection
@endsection
