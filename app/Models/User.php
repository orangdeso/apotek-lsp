<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Address;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property-read Collection<int, Address> $addresses
 * @method \Illuminate\Database\Eloquent\Relations\HasMany addresses()
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email', 
        'password',
        'alamat',
        'kota',
        'telpon',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'id_user');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function defaultAddress()
    {
        return $this->hasOne(Address::class)->where('is_default', true);
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isApoteker()
    {
        return $this->role === 'apoteker';
    }

    public function isPelanggan()
    {
        return $this->role === 'pelanggan';
    }
}
