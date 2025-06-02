<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'view dashboard',
            'manage users',
            'manage roles',
            'manage permissions',
            // Izin umum untuk chatbot
            'manage chatbot',
            // Izin spesifik untuk intents
            'view-intent',
            'create-intent',
            'edit-intent',
            'delete-intent',
            // Izin spesifik untuk questions
            'view-question',
            'create-question',
            'edit-question',
            'delete-question',
            // Izin spesifik untuk responses
            'view-response',
            'create-response',
            'edit-response',
            'delete-response',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}