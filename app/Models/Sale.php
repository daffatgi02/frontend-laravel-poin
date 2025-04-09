<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_penjualan';

    protected $fillable = [
        'store_id',
        'product_id',
        'jumlah',
        'harga_jual',
        'tanggal_penjualan',
        'bukti_penjualan',
        'status',
        'catatan',
        'catatan_admin'
    ];

    protected $casts = [
        'tanggal_penjualan' => 'date',
    ];

    /**
     * Get the store that made the sale.
     */
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id_toko');
    }

    /**
     * Get the product that was sold.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id_produk');
    }
}
