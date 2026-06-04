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
        return User::all();
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
}