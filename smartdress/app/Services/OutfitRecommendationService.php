<?php

namespace App\Services;

use App\Models\User;
use App\Models\Tenue;

class OutfitRecommendationService
{
    /**
     * Recommande la meilleure tenue pour un utilisateur selon la température.
     * 
     * @param User $user
     * @param float $temperature
     * @return Tenue|null
     */
    public function getBestOutfit(User $user, float $temperature): ?Tenue
    {
        // Déterminer le type de tenue (Été >= 15°C, Hiver < 15°C)
        $typeRecherche = ($temperature >= 15) ? 'Été' : 'Hiver';

        // Chercher une tenue de l'utilisateur dont le nom contient le type (Été ou Hiver)
        return $user->tenues()
            ->where('nom', 'LIKE', '%' . $typeRecherche . '%')
            ->inRandomOrder()
            ->first();
    }
}
