<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        // Role Super Admin (bisa mengelola semua)
        $superAdmin = Role::create(['name' => 'super-admin']);
        $superAdmin->givePermissionTo([
            'dashboard_read',
            'intents_create', 'intents_read', 'intents_update', 'intents_delete',
            'questions_create', 'questions_read', 'questions_update', 'questions_delete',
            'responses_create', 'responses_read', 'responses_update', 'responses_delete',
            'roles_create', 'roles_read', 'roles_update', 'roles_delete',
            'permissions_create', 'permissions_read', 'permissions_update', 'permissions_delete',
        ]);

        // Role Admin (bisa mengelola semua kecuali role)
        $admin = Role::create(['name' => 'admin']);

        // Role User (hanya bisa melihat)
        $user = Role::create(['name' => 'user']);

    }
}