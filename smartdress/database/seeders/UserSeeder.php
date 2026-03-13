<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création d'un administrateur
        User::firstOrCreate(
            ['email' => 'admin@smartdress.com'],
            [
                'name' => 'Admin SmartDress',
                'password' => Hash::make('password'),
            ]
        );

        // Création d'un utilisateur de test
        User::firstOrCreate(
            ['email' => 'user@smartdress.com'],
            [
                'name' => 'Yasmine User',
                'password' => Hash::make('password'),
            ]
        );
    }
}
