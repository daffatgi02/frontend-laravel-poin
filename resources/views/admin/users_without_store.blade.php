@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2><i class="fas fa-users me-2"></i>Pengguna Tanpa Toko</h2>
                        <p class="text-muted">Daftar pengguna yang belum memiliki toko dalam sistem.</p>
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
                            <span class="input-group-text bg-info text-white"><i class="fas fa-search"></i></span>
                            <input type="text" id="searchInput" class="form-control"
                                placeholder="Cari pengguna berdasarkan nama atau email...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                @if ($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0" id="usersTable">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Tanggal Registrasi</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr class="user-row">
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light me-2 rounded d-flex align-items-center justify-content-center"
                                                    style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user text-secondary"></i>
                                                </div>
                                                <span>{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal"
                                                data-bs-target="#createStoreModal-{{ $user->id }}">
                                                <i class="fas fa-plus-circle me-1"></i>Buat Toko
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-4x text-muted mb-3"></i>
                        <h4>Semua pengguna toko sudah memiliki toko</h4>
                        <p class="text-muted">Tidak ada pengguna dengan peran 'Toko' yang belum memiliki toko.</p>
                    </div>
                @endif
            </div>
            @if ($users->count() > 0)
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">Menampilkan <span id="visibleCount">{{ $users->count() }}</span> dari
                                {{ $users->count() }} pengguna</span>
                        </div>
                        <a href="{{ route('admin.stores') }}" class="btn btn-outline-primary">
                            <i class="fas fa-store me-1"></i>Lihat Semua Toko
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Create Store Modals -->
        @foreach ($users as $user)
            <div class="modal fade" id="createStoreModal-{{ $user->id }}" tabindex="-1"
                aria-labelledby="createStoreModalLabel-{{ $user->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title" id="createStoreModalLabel-{{ $user->id }}">
                                <i class="fas fa-store-alt me-2"></i>Buat Toko untuk {{ $user->name }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>Anda akan membuat toko untuk pengguna
                                <strong>{{ $user->name }}</strong> ({{ $user->email }}).
                            </p>

                            <form id="createStoreForm-{{ $user->id }}"
                                action="/admin/store/create-for-user" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">

                                <div class="mb-3">
                                    <label for="nama_toko-{{ $user->id }}" class="form-label">Nama Toko <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_toko-{{ $user->id }}"
                                        name="nama_toko" required>
                                </div>

                                <div class="mb-3">
                                    <label for="alamat-{{ $user->id }}" class="form-label">Alamat Toko <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="alamat-{{ $user->id }}" name="alamat" rows="3" required></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nama_pemilik-{{ $user->id }}" class="form-label">Nama Pemilik
                                                <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                id="nama_pemilik-{{ $user->id }}" name="nama_pemilik"
                                                value="{{ $user->name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="no_hp-{{ $user->id }}" class="form-label">No. HP <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="no_hp-{{ $user->id }}"
                                                name="no_hp" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="status-{{ $user->id }}" class="form-label">Status Toko</label>
                                    <select class="form-select" id="status-{{ $user->id }}" name="status">
                                        <option value="pending">Menunggu Verifikasi</option>
                                        <option value="verified">Terverifikasi</option>
                                        <option value="nonaktif">Nonaktif</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Foto Toko <span class="text-danger">*</span></label>
                                    <p class="text-muted small">Wajib upload 3 foto untuk toko ini.</p>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="card mb-2">
                                                <div class="card-body">
                                                    <label for="foto1-{{ $user->id }}" class="form-label">Foto
                                                        1</label>
                                                    <input type="file" class="form-control"
                                                        id="foto1-{{ $user->id }}" name="foto1" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card mb-2">
                                                <div class="card-body">
                                                    <label for="foto2-{{ $user->id }}" class="form-label">Foto
                                                        2</label>
                                                    <input type="file" class="form-control"
                                                        id="foto2-{{ $user->id }}" name="foto2" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card mb-2">
                                                <div class="card-body">
                                                    <label for="foto3-{{ $user->id }}" class="form-label">Foto
                                                        3</label>
                                                    <input type="file" class="form-control"
                                                        id="foto3-{{ $user->id }}" name="foto3" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" form="createStoreForm-{{ $user->id }}"
                                class="btn btn-info text-white">
                                <i class="fas fa-save me-1"></i>Buat Toko
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const userRows = document.querySelectorAll('.user-row');
            const visibleCount = document.getElementById('visibleCount');

            searchInput.addEventListener('keyup', function() {
                const searchText = this.value.toLowerCase();
                let count = 0;

                userRows.forEach(function(row) {
                    const userName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    const userEmail = row.querySelector('td:nth-child(3)').textContent
                        .toLowerCase();

                    if (userName.includes(searchText) || userEmail.includes(searchText)) {
                        row.style.display = '';
                        count++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                visibleCount.textContent = count;
            });
        });
    </script>
@endsection
@endsection
