<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Crée les rôles et leurs permissions
     */
    public function run(): void
    {
        // 🔹 Création ou récupération des rôles
        $adminRole = Role::firstOrCreate(['nom' => 'admin']);
        $userRole = Role::firstOrCreate(['nom' => 'utilisateur']);

        // 🔹 Liste des permissions pour admin
        $adminPermissions = [
            'manage_users',
            'manage_all_clothes',
        ];

        // 🔹 Liste des permissions pour utilisateur
        $userPermissions = [
            'view_own_clothes',
            'create_clothes',
        ];

        // 🔐 Attribution des permissions au rôle admin
        foreach ($adminPermissions as $permName) {
            // Créer la permission si elle n'existe pas
            $permission = Permission::firstOrCreate(['nom' => $permName]);

            // Associer la permission au rôle admin sans supprimer les existantes
            $adminRole->permissions()->syncWithoutDetaching([
                $permission->id
            ]);
        }

        // 👤 Attribution des permissions au rôle utilisateur
        foreach ($userPermissions as $permName) {
            $permission = Permission::firstOrCreate(['nom' => $permName]);

            $userRole->permissions()->syncWithoutDetaching([
                $permission->id
            ]);
        }
    }
}