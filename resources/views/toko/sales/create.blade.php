@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2><i class="fas fa-plus-circle me-2"></i>Catat Penjualan Baru</h2>
                        <p class="text-muted">Tambahkan catatan penjualan baru dengan bukti penjualan.</p>
                    </div>
                    <a href="{{ route('toko.sales.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar Penjualan
                    </a>
                </div>
            </div>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-1"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Formulir Penjualan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('toko.sales.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="product_id" class="form-label">Pilih Produk <span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('product_id') is-invalid @enderror" id="product_id"
                                name="product_id" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id_produk }}" data-harga="{{ $product->harga }}"
                                        data-stok="{{ $product->stok }}">
                                        {{ $product->nama_produk }} (Stok: {{ $product->stok }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tanggal_penjualan" class="form-label">Tanggal Penjualan <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_penjualan') is-invalid @enderror"
                                id="tanggal_penjualan" name="tanggal_penjualan"
                                value="{{ old('tanggal_penjualan', date('Y-m-d')) }}" required max="{{ date('Y-m-d') }}">
                            @error('tanggal_penjualan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="jumlah" class="form-label">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah"
                                name="jumlah" value="{{ old('jumlah', 1) }}" required min="1" max="1000">
                            @error('jumlah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-text" id="stokInfo">Stok tersedia: -</div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="harga_jual" class="form-label">Harga Jual (Rp) <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('harga_jual') is-invalid @enderror"
                                    id="harga_jual" name="harga_jual" value="{{ old('harga_jual') }}" required
                                    min="0">
                            </div>
                            @error('harga_jual')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-text" id="hargaInfo">Harga produk: -</div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="total" class="form-label">Total</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control" id="total" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="alert alert-info">
                            <div class="d-flex">
                                <i class="fas fa-info-circle fa-2x me-2"></i>
                                <div>
                                    <h5 class="alert-heading">Penting! Bukti Penjualan</h5>
                                    <p>Harap unggah bukti penjualan yang jelas dan valid. Ini akan digunakan untuk
                                        verifikasi penjualan oleh admin.</p>
                                    <ul>
                                        <li>Foto utama (Nota/Kwitansi) <strong>wajib diunggah</strong>.</li>
                                        <li>Tambahkan foto saat serah terima dengan pelanggan jika ada.</li>
                                        <li>Anda dapat mengunggah hingga 10 foto sebagai bukti tambahan.</li>
                                        <li>Format yang didukung: JPG, JPEG, PNG. Maksimal 2MB per file.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <label class="form-label fw-bold">Bukti Penjualan <span class="text-danger">*</span></label>

                        <!-- First required photo (Nota/Kwitansi) -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-receipt me-1"></i>Nota/Kwitansi (Wajib)</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="file"
                                            class="form-control @error('bukti_penjualan') is-invalid @enderror"
                                            id="bukti_penjualan" name="bukti_penjualan[]"
                                            accept="image/jpeg,image/png,image/jpg" required
                                            onchange="previewImage(this, 'preview-nota')">
                                        @error('bukti_penjualan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="form-text">Foto nota/kwitansi penjualan yang jelas (wajib).</div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <img id="preview-nota" src="https://via.placeholder.com/150?text=Nota/Kwitansi"
                                            class="img-fluid rounded" alt="Preview Nota" style="max-height: 150px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional photos container -->
                        <div id="additional-photos">
                            <!-- Dynamic photos will be added here -->
                        </div>

                        <!-- Add more photos button -->
                        <div class="text-center mb-3">
                            <button type="button" class="btn btn-outline-primary" id="addPhotoBtn">
                                <i class="fas fa-plus-circle me-1"></i>Tambah Foto Bukti Lainnya
                            </button>
                            <p class="text-muted small mt-1">Maksimal 9 foto tambahan (total 10 foto)</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('toko.sales.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan Penjualan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productSelect = document.getElementById('product_id');
            const jumlahInput = document.getElementById('jumlah');
            const hargaInput = document.getElementById('harga_jual');
            const totalInput = document.getElementById('total');
            const stokInfo = document.getElementById('stokInfo');
            const hargaInfo = document.getElementById('hargaInfo');
            const addPhotoBtn = document.getElementById('addPhotoBtn');
            const additionalPhotosContainer = document.getElementById('additional-photos');
            let photoCount = 1; // Start with 1 because we already have the required photo

            function updateProductInfo() {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                const harga = selectedOption.getAttribute('data-harga');
                const stok = selectedOption.getAttribute('data-stok');

                if (harga) {
                    hargaInput.value = harga;
                    hargaInfo.textContent = `Harga produk: Rp ${new Intl.NumberFormat('id-ID').format(harga)}`;
                } else {
                    hargaInput.value = '';
                    hargaInfo.textContent = 'Harga produk: -';
                }

                if (stok) {
                    jumlahInput.max = stok;
                    stokInfo.textContent = `Stok tersedia: ${stok}`;
                } else {
                    jumlahInput.max = 1000;
                    stokInfo.textContent = 'Stok tersedia: -';
                }

                updateTotal();
            }

            function updateTotal() {
                const jumlah = jumlahInput.value || 0;
                const harga = hargaInput.value || 0;
                const total = jumlah * harga;
                totalInput.value = new Intl.NumberFormat('id-ID').format(total);
            }

            function addPhotoField() {
                if (photoCount >= 10) {
                    alert('Maksimal 10 foto yang dapat diunggah (1 wajib + 9 tambahan).');
                    return;
                }

                const photoId = Date.now(); // Unique ID for this photo field
                const photoHtml = `
                <div class="card mb-3" id="photo-card-${photoId}">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="fas fa-image me-1"></i>Foto Bukti Tambahan #${photoCount}</h6>
                        <button type="button" class="btn btn-sm btn-danger remove-photo" data-id="${photoId}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="file" class="form-control" name="bukti_penjualan[]" accept="image/jpeg,image/png,image/jpg" onchange="previewImage(this, 'preview-${photoId}')">
                                <div class="form-text">Foto bukti pendukung seperti serah terima dengan pelanggan, dll.</div>
                            </div>
                            <div class="col-md-4 text-center">
                                <img id="preview-${photoId}" src="https://via.placeholder.com/150?text=Bukti+Tambahan" class="img-fluid rounded" alt="Preview" style="max-height: 150px;">
                            </div>
                        </div>
                    </div>
                </div>
            `;

                additionalPhotosContainer.insertAdjacentHTML('beforeend', photoHtml);
                photoCount++;

                // Add event listener to the remove button
                document.querySelector(`#photo-card-${photoId} .remove-photo`).addEventListener('click',
            function() {
                    document.getElementById(`photo-card-${photoId}`).remove();
                    photoCount--;
                });
            }

            // Event listeners
            productSelect.addEventListener('change', updateProductInfo);
            jumlahInput.addEventListener('input', updateTotal);
            hargaInput.addEventListener('input', updateTotal);
            addPhotoBtn.addEventListener('click', addPhotoField);

            // Initialize
            updateProductInfo();
        });

        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
@endsection
