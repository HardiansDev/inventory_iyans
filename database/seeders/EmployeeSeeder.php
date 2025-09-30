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

        \App\Models\Employee::create([
            'employee_number' => 'EMP002',
            'name' => 'Siti Rahma',
            'email' => 'siti@example.com',
            'phone' => '082233445566',
            'gender' => 'P',
            'birth_date' => '1997-03-15',
            'address' => 'Jl. Sudirman No.10',
            'department_id' => 2,
            'position_id' => 2,
            'status_id' => 1,
            'date_joined' => now(),
            'is_active' => true,
        ]);

        \App\Models\Employee::create([
            'employee_number' => 'EMP003',
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '083344556677',
            'gender' => 'L',
            'birth_date' => '1992-07-20',
            'address' => 'Jl. Gatot Subroto No.5',
            'department_id' => 3,
            'position_id' => 3,
            'status_id' => 2,
            'date_joined' => now()->subYears(2),
            'is_active' => true,
        ]);
    }
}
