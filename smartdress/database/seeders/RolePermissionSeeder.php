<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création des rôles
        $adminRole = Role::firstOrCreate(['nom' => 'admin']);
        $userRole = Role::firstOrCreate(['nom' => 'utilisateur']);

        // Création des permissions de base
        $permissions = [
            'manage_users',
            'manage_all_clothes',
            'view_own_clothes',
            'create_clothes',
        ];

        foreach ($permissions as $permName) {
            $permission = Permission::firstOrCreate(['nom' => $permName]);
            
            // Attribution des permissions (exemple simplifié)
            if ($permName === 'manage_users' || $permName === 'manage_all_clothes') {
                $adminRole->permissions()->syncWithoutDetaching([$permission->id]);
            } else {
                $userRole->permissions()->syncWithoutDetaching([$permission->id]);
            }
        }
    }
}
