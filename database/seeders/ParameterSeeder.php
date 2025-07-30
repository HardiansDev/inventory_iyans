<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Pic;

class ParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed categories
        $categories = [
            ['name' => 'Electronics'],
            ['name' => 'Furniture'],
            ['name' => 'Clothing'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Seed suppliers
        $suppliers = [
            ['name' => 'Supplier A', 'address' => 'Jl. Merdeka No.1'],
            ['name' => 'Supplier B', 'address' => 'Jl. Sudirman No.2'],
            ['name' => 'Supplier C', 'address' => 'Jl. Thamrin No.3'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        
    }
}
