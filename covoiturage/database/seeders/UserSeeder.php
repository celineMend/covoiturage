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
        $users = [
            [
                'nom' => "Hapsatou",
                'prenom' => "Thiam",
                'email' => "hapsatou.thiam@gmail.com",
                "role" => "admin",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ],

            [
                'nom' => "Talla",
                'prenom' => "Cheikh Saliou",
                'email' => "cheikhSaliou@gmail.com",
                "role" => "conducteur",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ],
            [
                'nom' => "Sagna",
                'prenom' => "Moussa",
                'email' => "sagna.moussa@gmail.com",
                "role" => "conducteur",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ],
          
            [
                'nom' => "Fall",
                'prenom' => "Adijaratou Oumy",
                'email' => "adijaratouOumy.fall@gmail.com",
                "role" => "passager",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ],
            [
                'nom' => "Marone",
                'prenom' => "Anna",
                'email' => "anna.marone@gmail.com",
                "role" => "passager",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ],
        ];
        foreach ($users as $user) {
            User::create($user);
        }
}
}