<?php

namespace App\Http\Controllers;

use App\Services\AdminDashboardService;
use App\Models\Vetement;

class AdminController extends Controller
{
    public function __construct(
        private readonly AdminDashboardService $adminDashboardService
    ) {
    }

    public function index()
    {
        // 1. Récupération des données existantes (Utilisateurs et Activités)
        $users = $this->adminDashboardService->getUsersForDashboard();
        $totalUsers = $users->count();
        $activities = $this->adminDashboardService->getRecentActivities($users);

        // 2. Récupération des vraies statistiques globales
        $totalVetements = $this->adminDashboardService->getTotalVetements();
        $totalTenues = $this->adminDashboardService->getTotalTenues();

        // 🟢 AJOUT : Récupération des vêtements avec leurs relations
        $vetements = Vetement::with(['user', 'photos'])->get()->map(function (Vetement $vetement) {
            // Associe dynamiquement les propriétés attendues par Alpine.js dans la vue
            $vetement->setAttribute('utilisateur', $vetement->user?->name ?? 'Inconnu');
            $photo = $vetement->photos->first();
            $vetement->setAttribute('image', $photo ? asset('storage/' . $photo->url) : null);

            $vetement->setAttribute('statut', 'Validé'); // Statut par défaut
            return $vetement;
        });

        // 3. On ajoute '$vetements' dans le compact() pour l'envoyer à la vue
        return view('pages.admin.admin-dashboard', compact(
            'users',
            'totalUsers',
            'activities',
            'totalVetements',
            'totalTenues',
            'vetements'
        ));
    }

}