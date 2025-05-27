<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // Dashboard
            'dashboard_read',

            // Intents
            'intents_create',
            'intents_read',
            'intents_update',
            'intents_delete',

            // Questions
            'questions_create',
            'questions_read',
            'questions_update',
            'questions_delete',

            // Responses
            'responses_create',
            'responses_read',
            'responses_update',
            'responses_delete',

            // Role Management
            'roles_create',
            'roles_read',
            'roles_update',
            'roles_delete',

            // Permission Management
            'permissions_create',
            'permissions_read',
            'permissions_update',
            'permissions_delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}