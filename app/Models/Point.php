<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'sale_id',
        'points',
        'description',
        'type'
    ];

    /**
     * Get the store that owns the points.
     */
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id_toko');
    }

    /**
     * Get the sale associated with the points.
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'id_penjualan');
    }
}
