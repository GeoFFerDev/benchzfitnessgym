<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Bench-Z Admin',
            'email' => 'admin@benchz.com', // Use this to log in
            'password' => Hash::make('admin12345'), // Change this to your preferred password
            'role' => 'admin',
        ]);
    }
}