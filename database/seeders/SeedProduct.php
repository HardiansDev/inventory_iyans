<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Pic;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SeedProduct extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [];

        for ($i = 1; $i <= 200; $i++) {
            $products[] = [
                'name' => "nama product {$i}",
                'code' => 'code 1',
                'photo' => 'jeruk.jpg',

                'price' => '1000',
                'qty' => '100',
                'stock' => '300',
                'quality' => 'good',
                'purchase' => 'purchase 1',
                'billnum' => 'billing number 1',

            ];
        }

        $categories = Category::get()->pluck("id");
        $suppliers = Supplier::get()->pluck("id");
        $pics = Pic::get()->pluck("id");
        foreach ($products as $key => $value) {
            $product = $value;
            $product['category_id'] = $categories[rand(0, $categories->count() - 1)];
            $product['supplier_id'] = $suppliers[rand(0, $suppliers->count() - 1)];
            $product['pic_id'] = $pics[rand(0, $pics->count() - 1)];
            Product::query()->create($product);
        }
    }
}
