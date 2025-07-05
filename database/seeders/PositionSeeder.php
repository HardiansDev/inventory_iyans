<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Position::insert([
            ['name' => 'Staff', 'base_salary' => 3000000],
            ['name' => 'Supervisor', 'base_salary' => 5000000],
            ['name' => 'Manager', 'base_salary' => 8000000],
        ]);
    }
}
