<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $categories = [1, 2, 3]; // ID kategori
        $satuans = [1, 2, 3, 4, 5]; // ID satuan (hasil dari SatuanSeeder)

        $products = [];
        $uniqueCodes = [];

        for ($i = 1; $i <= 10; ++$i) {
            // Pastikan kode unik
            do {
                $code = 'P-'.strtoupper(Str::random(8));
            } while (in_array($code, $uniqueCodes));
            $uniqueCodes[] = $code;

            $products[] = [
                'name' => "Product $i",
                'code' => $code,
                'photo' => "product_$i.jpg", // Lokasi foto dummy
                'category_id' => $categories[array_rand($categories)],
                'satuan_id' => $satuans[array_rand($satuans)],

                'price' => mt_rand(5, 50) * 1000,
                'stock' => mt_rand(0, 500), // Stok antara 0 hingga 500
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert data ke tabel produk
        Product::insert($products);
    }
}
