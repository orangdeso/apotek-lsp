<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obat';
    protected $primaryKey = 'id_obat';

    protected $fillable = [
        'name_obat',
        'type',
        'unit',
        'purchase_price',
        'sale_price',
        'stok',
        'description',
        'image',
        'expdate',
        'id_supplier'
    ];

    protected $casts = [
        'expdate' => 'date',
        'purchase_price' => 'decimal:2',
        'sale_price' => 'decimal:2'
    ];

    // Relationships
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }

    public function penjualanDetails()
    {
        return $this->hasMany(PenjualanDetail::class, 'id_obat', 'id_obat');
    }

    public function pembelianDetails()
    {
        return $this->hasMany(PembelianDetail::class, 'id_obat', 'id_obat');
    }

    // Helper methods
    public function isExpired()
    {
        return $this->expdate < now();
    }

    public function isLowStock($threshold = 10)
    {
        return $this->stok <= $threshold;
    }
}