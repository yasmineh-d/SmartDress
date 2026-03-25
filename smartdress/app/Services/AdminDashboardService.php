<?php

namespace App\Services;

use App\Models\User;
use App\Models\Vetement;
use App\Models\Tenue;

class AdminDashboardService
{
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
