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
        $this->call(UserRoleSeeder::class);
        $this->call(ParameterSeeder::class);
        $this->call(SatuanSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(BahanBakuSeeder::class);

        $this->call([
            DepartmentSeeder::class,
            PositionSeeder::class,
            EmploymentStatusSeeder::class,
            EmployeeSeeder::class,
        ]);
    }
}
