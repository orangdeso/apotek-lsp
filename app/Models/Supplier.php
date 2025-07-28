<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';
    protected $primaryKey = 'id_supplier';
    
    protected $fillable = [
        'name_supplier',
        'alamat',
        'kota',
        'telpon'
    ];

    public function obats()
    {
        return $this->hasMany(Obat::class, 'id_supplier');
    }

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class, 'id_supplier');
    }
}