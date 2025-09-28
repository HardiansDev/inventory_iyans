<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'super@mail.com',
                'password' => Hash::make('admin123'),
                'role' => 'superadmin',
            ],
            [
                'name' => 'Admin Gudang',
                'email' => 'gudang@mail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin_gudang',
            ],
            [
                'name' => 'Kasir',
                'email' => 'kasir@mail.com',
                'password' => Hash::make('admin123'),
                'role' => 'kasir',
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@mail.com',
                'password' => Hash::make('admin123'),
                'role' => 'manager',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
