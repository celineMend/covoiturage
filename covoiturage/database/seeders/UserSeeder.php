<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        User::create([
            'name' => 'Passager 1',
            'email' => 'passager1@example.com',
            'password' => bcrypt('password'),
        ]);
        User::create([
            'name' => 'Conducteur 1',
            'email' => 'conducteur1@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}
