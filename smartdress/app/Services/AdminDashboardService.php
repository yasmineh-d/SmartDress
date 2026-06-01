<?php

namespace App\Services;

use App\Models\User;
use App\Models\Vetement;
use App\Models\Tenue;
use Illuminate\Support\Collection;

class AdminDashboardService
{
    /**
     * Récupère les utilisateurs formatés pour le tableau de bord admin.
     */
    public function getUsersForDashboard(): Collection
    {
        return User::with('roles')->get()->map(function (User $user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->roles->first()?->nom ?? 'User',
                'status' => 'Actif',
            ];
        });
    }

    /**
     * Récupère les activités affichées dans le tableau de bord admin.
     */
    public function getRecentActivities(Collection $users): array
    {
        $firstUser = $users->first();

        return [
            [
                'id' => 1,
                'initial' => $firstUser ? substr($firstUser['name'], 0, 2) : 'YA',
                'name' => $firstUser ? $firstUser['name'] : 'Admin',
                'action' => 'Connexion système',
                'time' => 'Maintenant',
            ],
        ];
    }

    /**
     * Récupère le nombre total d'utilisateurs inscrits sur la plateforme.
     * 
     * @return int
     */
    public function getTotalUsersCount(): int
    {
        return User::count();
    }

    /**
     * Récupère le nombre total de vêtements ajoutés par tous les utilisateurs.
     * 
     * @return int
     */
    public function cloneAllClothesCount(): int
    {
        return Vetement::count();
    }

    /**
     * Récupère le nombre total de tenues créées sur la plateforme.
     * 
     * @return int
     */
    public function getTotalOutfitsCount(): int
    {
        return Tenue::count();
    }

    /**
     * Calcule la moyenne du nombre de vêtements par utilisateur.
     * 
     * @return float
     */
    public function getAverageClothesPerUser(): float
    {
        $usersCount = $this->getTotalUsersCount();
        
        if ($usersCount === 0) {
            return 0.0;
        }

        $totalClothes = $this->cloneAllClothesCount();
        return round($totalClothes / $usersCount, 2);
    }
}
