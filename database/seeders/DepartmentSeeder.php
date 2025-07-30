<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Department::insert([
            ['name' => 'HRD'],
            ['name' => 'IT'],
            ['name' => 'Finance'],
        ]);
    }
}
