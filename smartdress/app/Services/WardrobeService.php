<?php

namespace App\Services;

use App\Models\User;

class WardrobeService
{
    /**
     * Vérifie si l'utilisateur possède suffisamment de vêtements pour composer une tenue de base.
     * (Au moins 1 haut, 1 bas, et 1 paire de chaussures).
     * 
     * @param User $user
     * @return bool
     */
    public function hasEnoughClothesForOutfit(User $user): bool
    {
        $hasHaut = $user->vetements()->where('categorie', 'Hauts')->exists();
        $hasBas = $user->vetements()->where('categorie', 'Bas')->exists();
        $hasChaussures = $user->vetements()->where('categorie', 'Chaussures')->exists();

        return $hasHaut && $hasBas && $hasChaussures;
    }

    /**
     * Récupère les vêtements favoris de l'utilisateur.
     * Suppose que la relation "favoris" existe dans le modèle User ou Vetement.
     */
    public function getFavoriteClothes(User $user)
    {
        // En supposant que le modèle User a une relation "favoris" de type "hasMany" vers "Favoris" 
        // ou une relation de type "belongsToMany" ("favoris") vers "Vetement".
        // Le seeder ne montrait pas cette structure, on fait une requête factice ou conceptuelle.
        if (method_exists($user, 'favoris')) {
            return $user->favoris()->with('vetement')->get();
        }

        // Si la relation n'existe pas encore, on retourne une collection vide.
        return collect([]);
    }
}
