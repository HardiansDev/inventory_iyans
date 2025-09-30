<?php

namespace Database\Seeders;

use App\Models\BahanBaku;
use Illuminate\Database\Seeder;

class BahanBakuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BahanBaku::create([
            'name' => 'Gula Pasir',
            'supplier_id' => 1,
            'category_id' => 4, // kategori bahan baku
            'satuan_id' => 1,   // misalnya pcs/kg/liter (disesuaikan)
            'stock' => 100,
            'price' => 12000,
            'description' => 'Gula pasir kualitas premium',
        ]);

        BahanBaku::create([
            'name' => 'Tepung Terigu',
            'supplier_id' => 2,
            'category_id' => 4,
            'satuan_id' => 2,
            'stock' => 200,
            'price' => 8000,
            'description' => 'Tepung terigu protein sedang',
        ]);

        BahanBaku::create([
            'name' => 'Minyak Goreng',
            'supplier_id' => 3,
            'category_id' => 4,
            'satuan_id' => 3,
            'stock' => 150,
            'price' => 14000,
            'description' => 'Minyak goreng kemasan botol 1 liter',
        ]);

        BahanBaku::create([
            'name' => 'Telur Ayam',
            'supplier_id' => 4,
            'category_id' => 4,
            'satuan_id' => 4,
            'stock' => 300,
            'price' => 2000,
            'description' => 'Telur ayam ras segar',
        ]);

        BahanBaku::create([
            'name' => 'Susu Bubuk',
            'supplier_id' => 5,
            'category_id' => 4,
            'satuan_id' => 5,
            'stock' => 80,
            'price' => 45000,
            'description' => 'Susu bubuk full cream kemasan 1 kg',
        ]);
    }
}
