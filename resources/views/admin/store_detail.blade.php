@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-store me-2"></i>Detail Toko</h2>
                    <p class="text-muted">Lihat dan kelola informasi toko.</p>
                </div>
                <a href="{{ route('admin.stores') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar Toko
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

    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>{{ $store->nama_toko }}
                        <span class="badge bg-light text-dark float-end">#{{ $store->id_toko }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="border-bottom pb-2 mb-3">Informasi Toko</h5>

                            <div class="mb-3">
                                <label class="form-label text-muted">Nama Toko</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-store"></i></span>
                                    <input type="text" class="form-control" value="{{ $store->nama_toko }}" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Alamat</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <textarea class="form-control" rows="3" readonly>{{ $store->alamat }}</textarea>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Status</label>
                                <div>
                                    @if ($store->status == 'pending')
                                        <span class="badge bg-warning p-2"><i class="fas fa-clock me-1"></i>Menunggu Verifikasi</span>
                                    @elseif ($store->status == 'verified')
                                        <span class="badge bg-success p-2"><i class="fas fa-check-circle me-1"></i>Terverifikasi</span>
                                    @else
                                        <span class="badge bg-danger p-2"><i class="fas fa-times-circle me-1"></i>Nonaktif</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h5 class="border-bottom pb-2 mb-3">Informasi Pemilik</h5>

                            <div class="mb-3">
                                <label class="form-label text-muted">Nama Pemilik</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" value="{{ $store->nama_pemilik }}" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">No. HP</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="form-control" value="{{ $store->no_hp }}" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="text" class="form-control" value="{{ $store->user->email }}" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Tanggal Pendaftaran</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="text" class="form-control" value="{{ $store->created_at->format('d M Y H:i') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="border-bottom pb-2 mb-3">Foto Toko</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="{{ asset('storage/' . $store->foto1) }}" class="card-img-top" alt="Foto 1" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="card-title">Foto 1</h6>
                                    <p class="card-text small">Tampak depan toko</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="{{ asset('storage/' . $store->foto2) }}" class="card-img-top" alt="Foto 2" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="card-title">Foto 2</h6>
                                    <p class="card-text small">Tampak interior toko</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="{{ asset('storage/' . $store->foto3) }}" class="card-img-top" alt="Foto 3" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="card-title">Foto 3</h6>
                                    <p class="card-text small">Foto produk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Pengaturan Toko</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.update_store_status', $store->id_toko) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="status" class="form-label">Ubah Status Toko</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="pending" {{ $store->status == 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                <option value="verified" {{ $store->status == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                                <option value="nonaktif" {{ $store->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tindakan</label>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Perbarui Status
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="alert alert-info mt-4">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-info-circle fa-2x"></i>
                            </div>
                            <div>
                                <h6>Informasi Status</h6>
                                <ul class="mb-0 ps-3">
                                    <li><strong>Menunggu Verifikasi</strong> - Toko baru mendaftar dan belum diverifikasi.</li>
                                    <li><strong>Terverifikasi</strong> - Toko telah diverifikasi dan dapat beroperasi.</li>
                                    <li><strong>Nonaktif</strong> - Toko dinonaktifkan dan tidak dapat beroperasi.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Informasi Akun</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-light p-3 rounded me-3">
                            <i class="fas fa-user fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $store->user->name }}</h6>
                            <p class="text-muted mb-0">{{ $store->user->email }}</p>
                        </div>
                    </div>

                    <div class="card bg-light mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Peran</h6>
                                    <p class="mb-0">{{ $store->user->role }}</p>
                                </div>
                                <span class="badge bg-primary">{{ $store->user->role }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-light">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">ID Pengguna</h6>
                                    <p class="mb-0">{{ $store->user->id }}</p>
                                </div>
                                <span class="badge bg-secondary">#{{ $store->user->id }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
