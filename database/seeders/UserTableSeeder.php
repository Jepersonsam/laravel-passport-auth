<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('superadmin123'),
        ]);
        $superAdmin->assignRole('super-admin');

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com', 
            'password' => bcrypt('admin123'),
        ]);

        $admin->assignRole('admin');

        $user = User::create([
            'name' => 'User',
            'email' => 'user@gmail.com', 
            'password' => bcrypt('user12345'),
        ]);
        $user->assignRole('user');
    }
}
