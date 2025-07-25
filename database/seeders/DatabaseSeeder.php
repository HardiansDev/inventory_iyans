<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(UserRoleSeeder::class);
        $this->call(ParameterSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call([
            DepartmentSeeder::class,
            PositionSeeder::class,
            EmploymentStatusSeeder::class,
            EmployeeSeeder::class,
        ]);
    }
}
