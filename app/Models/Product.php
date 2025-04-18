<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'store_id',
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'foto_produk',
        'reward_poin',
    ];

    /**
     * Get the store that owns the product.
     */
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id_toko');
    }
    /**
     * Get the sales for the product.
     */
    public function sales()
    {
        return $this->hasMany(Sale::class, 'product_id', 'id_produk');
    }
     /**
     * Get the available stock (total stock minus reserved stock)
     *
     * @return int
     */
    public function getAvailableStockAttribute()
    {
        return $this->stok - $this->reserved_stock;
    }
}
