<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SeedSupplier extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            Supplier::query()->create([
                'name' => "Supplier {$i}",
                'address' => "SupplierAddress {$i}"
            ]);
        }
    }
}
