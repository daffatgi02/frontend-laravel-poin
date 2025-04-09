<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Penjualan #{{ $sale->id_penjualan }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 14px;
            line-height: 1.5;
        }
        .container {
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .subtitle {
            font-size: 16px;
            color: #666;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 16px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .info-row {
            display: flex;
            margin-bottom: 5px;
        }
        .info-label {
            width: 150px;
            font-weight: bold;
        }
        .info-value {
            flex: 1;
        }
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .product-table th, .product-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .product-table th {
            background-color: #f5f5f5;
        }
        .total-section {
            margin-top: 30px;
            text-align: right;
        }
        .total-label {
            font-weight: bold;
            font-size: 16px;
            margin-right: 10px;
        }
        .total-value {
            font-weight: bold;
            font-size: 18px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="title">BUKTI PENJUALAN</div>
            <div class="subtitle">{{ $sale->store->nama_toko }}</div>
        </div>

        <div class="info-section">
            <div class="info-title">Informasi Penjualan</div>
            <div class="info-row">
                <div class="info-label">No. Penjualan:</div>
                <div class="info-value">#{{ $sale->id_penjualan }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal:</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($sale->tanggal_penjualan)->format('d M Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Status:</div>
                <div class="info-value">
                    @if ($sale->status == 'pending')
                        Menunggu Verifikasi
                    @elseif ($sale->status == 'verified')
                        Terverifikasi
                    @else
                        Ditolak
                    @endif
                </div>
            </div>
        </div>

        <div class="info-section">
            <div class="info-title">Informasi Toko</div>
            <div class="info-row">
                <div class="info-label">Nama Toko:</div>
                <div class="info-value">{{ $sale->store->nama_toko }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Pemilik:</div>
                <div class="info-value">{{ $sale->store->nama_pemilik }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Alamat:</div>
                <div class="info-value">{{ $sale->store->alamat }}</div>
            </div>
        </div>

        <div class="info-section">
            <div class="info-title">Detail Produk</div>
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $sale->product->nama_produk }}</td>
                        <td>{{ $sale->jumlah }}</td>
                        <td>Rp {{ number_format($sale->harga_jual, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($sale->jumlah * $sale->harga_jual, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="total-section">
            <span class="total-label">Total:</span>
            <span class="total-value">Rp {{ number_format($sale->jumlah * $sale->harga_jual, 0, ',', '.') }}</span>
        </div>

        @if ($sale->catatan)
        <div class="info-section">
            <div class="info-title">Catatan</div>
            <p>{{ $sale->catatan }}</p>
        </div>
        @endif

        <div class="footer">
            <p>Dokumen ini dibuat pada {{ $sale->created_at->format('d M Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
