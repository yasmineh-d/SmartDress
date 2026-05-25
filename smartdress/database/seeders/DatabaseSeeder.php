<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Methode principale qui lance tous les seeders
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            VetementSeeder::class,
            TenueSeeder::class,
            TenueVetementSeeder::class,
            CommentaireSeeder::class,
            FavorisSeeder::class,
        ]);
    }
}
