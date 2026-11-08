<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => env('ADMIN_EMAIL'),
            ],
            [
                'name' => env('ADMIN_NAME'),
                'username' => env('ADMIN_USERNAME'),
                'password' => Hash::make(env('ADMIN_PASSWORD')),
                'role' => 'admin',
                'is_active' => true,
            ]
        );
    }
}