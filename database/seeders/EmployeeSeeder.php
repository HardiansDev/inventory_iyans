<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Employee::create([
            'employee_number' => 'EMP001',
            'name' => 'Andi Wijaya',
            'email' => 'andi@example.com',
            'phone' => '08123456789',
            'gender' => 'L',
            'birth_date' => '1995-01-01',
            'address' => 'Jl. Merdeka No.1',
            'department_id' => 1,
            'position_id' => 1,
            'status_id' => 1,
            'date_joined' => now(),
            'is_active' => true,
        ]);
    }
}
