<?php

namespace Database\Seeders;

use App\Models\Obat;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ObatSeeder extends Seeder
{
    public function run(): void
    {
        $obats = [
            [
                'name_obat' => 'Paracetamol 500mg',
                'type' => 'tablet',
                'unit' => 'strip',
                'purchase_price' => 5000.00,
                'sale_price' => 8000.00,
                'stok' => 100,
                'description' => 'Obat penurun demam dan pereda nyeri',
                'image' => 'obat-images/paracetamol-500mg.jpg',
                'expdate' => Carbon::now()->addYears(2),
                'id_supplier' => 1
            ],
            [
                'name_obat' => 'Amoxicillin 500mg',
                'type' => 'kapsul',
                'unit' => 'strip',
                'purchase_price' => 15000.00,
                'sale_price' => 25000.00,
                'stok' => 75,
                'description' => 'Antibiotik untuk infeksi bakteri',
                'image' => 'obat-images/amoxicillin-500mg.jpg',
                'expdate' => Carbon::now()->addYears(3),
                'id_supplier' => 2
            ],
            [
                'name_obat' => 'Vitamin C 1000mg',
                'type' => 'tablet',
                'unit' => 'botol',
                'purchase_price' => 25000.00,
                'sale_price' => 40000.00,
                'stok' => 50,
                'description' => 'Suplemen vitamin C untuk daya tahan tubuh',
                'image' => 'obat-images/vitamin-c-1000mg.jpg',
                'expdate' => Carbon::now()->addYears(2),
                'id_supplier' => 3
            ],
            [
                'name_obat' => 'Vitamin C 2000mg',
                'type' => 'tablet',
                'unit' => 'botol',
                'purchase_price' => 35000.00,
                'sale_price' => 50000.00,
                'stok' => 50,
                'description' => 'Suplemen vitamin C untuk daya tahan tubuh',
                'image' => 'obat-images/vitamin-c-1000mg.jpg',
                'expdate' => Carbon::now()->addYears(2),
                'id_supplier' => 3
            ],
            [
                'name_obat' => 'Lameson 8mg',
                'type' => 'tablet',
                'unit' => 'strip',
                'purchase_price' => 100000.00,
                'sale_price' => 90000.00,
                'stok' => 50,
                'description' => 'Suplemen lameson untuk daya tahan tubuh',
                'image' => 'obat-images/vitamin-c-1000mg.jpg',
                'expdate' => Carbon::now()->addYears(2),
                'id_supplier' => 3
            ]
        ];

        foreach ($obats as $obat) {
            Obat::create($obat);
        }
    }
}