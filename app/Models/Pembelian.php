<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian';
    protected $primaryKey = 'id_pembelian';

    protected $fillable = [
        'id_supplier',
        'total',
        'status'
    ];

    protected $casts = [
        'total' => 'decimal:2'
    ];

    // Relationships
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }

    public function pembelianDetails()
    {
        return $this->hasMany(PembelianDetail::class, 'id_pembelian', 'id_pembelian');
    }

    // Helper methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }
}