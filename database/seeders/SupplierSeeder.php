<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name_supplier' => 'PT Kimia Farma',
                'alamat' => 'Jl. Veteran No. 9',
                'kota' => 'Jakarta',
                'telpon' => '021-3847823'
            ],
            [
                'name_supplier' => 'PT Kalbe Farma',
                'alamat' => 'Jl. Letjen Suprapto Kav. 4',
                'kota' => 'Jakarta',
                'telpon' => '021-4270088'
            ],
            [
                'name_supplier' => 'PT Dexa Medica',
                'alamat' => 'Jl. Bambang Utoyo No. 138',
                'kota' => 'Palembang',
                'telpon' => '0711-710081'
            ]
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}