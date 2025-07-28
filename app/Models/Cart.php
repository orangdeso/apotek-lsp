<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';
    protected $primaryKey = 'id_cart';
    
    protected $fillable = [
        'user_id',
        'id_obat',
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer'
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke model Obat
     */
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }

    /**
     * Hitung subtotal untuk item ini
     */
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->price;
    }

    /**
     * Scope untuk mendapatkan cart berdasarkan user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Static method untuk mendapatkan total item di cart user
     */
    public static function getTotalItemsForUser($userId)
    {
        return static::where('user_id', $userId)->sum('quantity');
    }

    /**
     * Static method untuk mendapatkan total harga cart user
     */
    public static function getTotalPriceForUser($userId)
    {
        return static::where('user_id', $userId)
            ->get()
            ->sum(function ($item) {
                return $item->quantity * $item->price;
            });
    }
}