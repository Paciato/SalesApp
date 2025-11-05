<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('123abc'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Sales User',
            'email' => 'sales@example.com',
            'password' => bcrypt('123abc'),
            'role' => 'sales',
        ]);
    }
}
