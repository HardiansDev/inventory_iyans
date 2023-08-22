<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class SeedCategory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        for ($i = 1; $i <= 5; $i++) {
            Category::query()->create([
                'name' => "Category {$i}"
            ]);
        }
    }
}
