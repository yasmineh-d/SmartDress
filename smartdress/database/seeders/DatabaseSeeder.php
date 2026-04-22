<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Méthode principale qui lance tous les seeders
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class, // 🔐 Crée les rôles et leurs permissions
            UserSeeder::class,           // 👤 Crée les utilisateurs et leur attribue des rôles
            VetementSeeder::class,       // 👕 Ajoute les vêtements pour un utilisateur
            TenueSeeder::class,          // 👗 Crée des tenues et les lie aux vêtements
            CommentaireSeeder::class,    // 💬 Ajoute des commentaires sur les tenues
        ]);
    }
}