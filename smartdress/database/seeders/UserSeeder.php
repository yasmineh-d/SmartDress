<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Crée les utilisateurs et leur attribue des rôles
     */
    public function run(): void
    {
        // 🔹 Récupération des rôles existants
        $adminRole = Role::where('nom', 'admin')->first();
        $userRole = Role::where('nom', 'utilisateur')->first();

        // 👑 Création ou récupération de l'admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@smartdress.com'],
            [
                'name' => 'Admin SmartDress',
                'password' => Hash::make('password'),
            ]
        );

        // 🔐 Associer le rôle admin
        if ($adminRole) {
            $admin->roles()->syncWithoutDetaching([$adminRole->id]);
        }

        // 👤 Création ou récupération d'un utilisateur simple
        $user = User::firstOrCreate(
            ['email' => 'user@smartdress.com'],
            [
                'name' => 'Yasmine User',
                'password' => Hash::make('password'),
            ]
        );

        // 🔐 Associer le rôle utilisateur
        if ($userRole) {
            $user->roles()->syncWithoutDetaching([$userRole->id]);
        }
    }
}