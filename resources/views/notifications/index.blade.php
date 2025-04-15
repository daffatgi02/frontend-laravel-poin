@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-bell me-2"></i>Notifikasi</h2>
                    <p class="text-muted">Lihat semua notifikasi aktivitas toko Anda.</p>
                </div>
                <div>
                    @if($notifications->count() > 0)
                        <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="fas fa-check-double me-1"></i>Tandai Semua Dibaca
                            </button>
                        </form>

                        <button type="button" class="btn btn-outline-danger me-2" data-bs-toggle="modal" data-bs-target="#deleteAllModal">
                            <i class="fas fa-trash-alt me-1"></i>Hapus Semua
                        </button>
                    @endif

                    <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('toko.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
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
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-bell me-2"></i>Semua Notifikasi</h5>
        </div>
        <div class="card-body p-0">
            @if ($notifications->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach ($notifications as $notification)
                        <div class="list-group-item list-group-item-action py-3 {{ $notification->read_at ? '' : 'list-group-item-light' }}">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <a href="{{ route('notifications.click', $notification->id) }}" class="text-decoration-none text-dark">
                                        @if (isset($notification->data['type']))
                                            @if ($notification->data['type'] == 'store_verification')
                                                <i class="fas fa-store text-primary me-2"></i>
                                            @elseif ($notification->data['type'] == 'sale_verified')
                                                <i class="fas fa-check-circle text-success me-2"></i>
                                            @elseif ($notification->data['type'] == 'sale_rejected')
                                                <i class="fas fa-times-circle text-danger me-2"></i>
                                            @elseif ($notification->data['type'] == 'points_earned')
                                                <i class="fas fa-coins text-warning me-2"></i>
                                            @elseif ($notification->data['type'] == 'new_sale')
                                                <i class="fas fa-shopping-cart text-info me-2"></i>
                                            @else
                                                <i class="fas fa-bell text-secondary me-2"></i>
                                            @endif
                                        @else
                                            <i class="fas fa-bell text-secondary me-2"></i>
                                        @endif
                                        <span>{{ $notification->data['message'] ?? 'Notifikasi baru' }}</span>
                                    </a>
                                </div>
                                <div class="d-flex align-items-center">
                                    <small class="text-muted me-3">{{ $notification->created_at->diffForHumans() }}</small>
                                    @if (!$notification->read_at)
                                        <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="me-2">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <!-- Tombol untuk memicu modal delete notifikasi tunggal -->
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $notification->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Hapus Notifikasi Tunggal -->
                        <div class="modal fade" id="deleteModal-{{ $notification->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $notification->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title" id="deleteModalLabel-{{ $notification->id }}">
                                            <i class="fas fa-exclamation-triangle me-2"></i>Hapus Notifikasi
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus notifikasi ini? Tindakan ini tidak dapat dibatalkan.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('notifications.delete', $notification->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash-alt me-1"></i>Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center pt-4 pb-2">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-bell-slash fa-4x text-muted mb-3"></i>
                    <h4>Tidak Ada Notifikasi</h4>
                    <p class="text-muted">Anda belum memiliki notifikasi.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete All Notifications Modal -->
<div class="modal fade" id="deleteAllModal" tabindex="-1" aria-labelledby="deleteAllModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteAllModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Hapus Semua Notifikasi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus semua notifikasi? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('notifications.deleteAll') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-1"></i>Hapus Semua
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
