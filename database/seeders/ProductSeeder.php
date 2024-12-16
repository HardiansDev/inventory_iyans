<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $categories = [1, 2, 3]; // ID kategori
        $suppliers = [1, 2, 3];  // ID supplier

        $products = [];
        $uniqueCodes = [];

        for ($i = 1; $i <= 10; $i++) {
            // Pastikan kode unik
            do {
                $code = 'P-' . strtoupper(Str::random(8));
            } while (in_array($code, $uniqueCodes));
            $uniqueCodes[] = $code;

            $products[] = [
                'name' => "Product $i",
                'code' => $code,
                'photo' => "product_$i.jpg", // Lokasi foto dummy
                'category_id' => $categories[array_rand($categories)],
                'supplier_id' => $suppliers[array_rand($suppliers)],
                'price' => mt_rand(1000, 100000) / 100, // Harga antara 10.00 hingga 1000.00
                'stock' => mt_rand(0, 500), // Stok antara 0 hingga 500
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert data ke tabel produk
        Product::insert($products);
    }
}
