<?php

namespace App\Http\Controllers;

use App\Services\AdminDashboardService;

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

        // 2. AJOUT : Récupération des vraies statistiques globales depuis ton Service
        // (Ajuste les noms des méthodes si elles s'appellent différemment dans ton AdminDashboardService)
        $totalVetements = $this->adminDashboardService->getTotalVetements(); 
        $totalTenues = $this->adminDashboardService->getTotalTenues();

        // 3. MODIFICATION : On ajoute les nouvelles variables dans le compact() pour les envoyer à la vue
        return view('pages.admin.admin-dashboard', compact(
            'users', 
            'totalUsers', 
            'activities', 
            'totalVetements', 
            'totalTenues'
        ));
    }
}