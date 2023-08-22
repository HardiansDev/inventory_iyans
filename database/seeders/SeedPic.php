<?php

namespace Database\Seeders;

use App\Models\Pic;
use Illuminate\Database\Seeder;

class SeedPic extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            Pic::query()->create([
                'name' => "Pic {$i}"

            ]);
        }
    }
}
