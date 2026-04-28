<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Client',
            'email' => 'client@mail.com',
            'password' => bcrypt('password'),
            'role' => 'client'
        ]);

        User::create([
            'name' => 'Arsitek',
            'email' => 'arsitek@mail.com',
            'password' => bcrypt('password'),
            'role' => 'arsitek'
        ]);
    }
}
