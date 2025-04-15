<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_toko';

    protected $fillable = [
        'user_id',
        'nama_toko',
        'alamat',
        'nama_pemilik',
        'no_hp',
        'foto1',
        'foto2',
        'foto3',
        'status',
    ];

    /**
     * Get the user that owns the store.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the products for the store.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'store_id', 'id_toko');
    }

    /**
     * Check if store is verified
     */
    public function isVerified()
    {
        return $this->status === 'verified';
    }
    /**
     * Get the sales for the store.
     */
    public function sales()
    {
        return $this->hasMany(Sale::class, 'store_id', 'id_toko');
    }

    /**
     * Get the point transactions for the store.
     */
    public function points()
    {
        return $this->hasMany(Point::class, 'store_id', 'id_toko');
    }

    /**
     * Get the total points for the store.
     */
    public function getTotalPointsAttribute()
    {
        return $this->points()
            ->where('type', 'earned')
            ->sum('points') -
            $this->points()
            ->where('type', 'redeemed')
            ->sum('points');
    }
}
