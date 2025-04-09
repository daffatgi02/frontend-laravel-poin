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
}
