<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmploymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\EmploymentStatus::insert([
            ['name' => 'Tetap'],
            ['name' => 'Kontrak'],
            ['name' => 'Magang'],
        ]);
    }
}
