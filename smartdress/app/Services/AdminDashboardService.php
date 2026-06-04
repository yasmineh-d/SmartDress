<?php

namespace App\Services;

use App\Models\User;
use App\Models\Vetement;
use App\Models\Tenue;
use Illuminate\Support\Collection;

class AdminDashboardService
{
    /**
     * Récupérer les utilisateurs pour le tableau de bord.
     */
    public function getUsersForDashboard(): Collection
    {
        $users = User::with('roles')->get();
        foreach ($users as $user) {
            $roleName = $user->roles->first()?->nom;
            $user->setAttribute('role', $roleName === 'admin' ? 'Admin' : 'User');
            $user->setAttribute('status', 'Actif');
        }
        return $users;
    }

    /**
     * Générer ou récupérer les activités récentes.
     */
    public function getRecentActivities(Collection $users): array
    {
        // Retourne un tableau d'activités (soit via ta DB, soit tes données de test actuelles)
        return [
            [
                'id' => 1,
                'name' => $users->first()?->name ?? 'Yasmine Haddad',
                'action' => 'Génération de tenue - Style Casual',
                'time' => 'Il y a 5 min',
                'initial' => 'YH'
            ],
            [
                'id' => 2,
                'name' => $users->last()?->name ?? 'Anas Mansour',
                'action' => 'Ajout vêtement - Categorie Hauts',
                'time' => 'Il y a 12 min',
                'initial' => 'AM'
            ]
        ];
    }

    /**
     * AJOUT : Compter le nombre total de vêtements sur toute la plateforme.
     */
    public function getTotalVetements(): int
    {
        return Vetement::count();
    }

    /**
     * AJOUT : Compter le nombre total de tenues générées sur la plateforme.
     */
    public function getTotalTenues(): int
    {
        // Compte le nombre de lignes dans ta table tenues
        return Tenue::count();
    }

    /**
     * Obtenir le nombre total d'utilisateurs.
     */
    public function getTotalUsersCount(): int
    {
        return User::count();
    }

    /**
     * Obtenir le nombre total de vêtements (alias pour le test).
     */
    public function cloneAllClothesCount(): int
    {
        return $this->getTotalVetements();
    }

    /**
     * Obtenir le nombre total de tenues (alias pour le test).
     */
    public function getTotalOutfitsCount(): int
    {
        return $this->getTotalTenues();
    }

    /**
     * Calculer le nombre moyen de vêtements par utilisateur.
     */
    public function getAverageClothesPerUser(): float
    {
        $usersCount = User::count();
        if ($usersCount === 0) {
            return 0.0;
        }
        return Vetement::count() / $usersCount;
    }
}