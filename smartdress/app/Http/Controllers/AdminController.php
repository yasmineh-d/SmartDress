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
        $users = $this->adminDashboardService->getUsersForDashboard();
        $totalUsers = $users->count();
        $activities = $this->adminDashboardService->getRecentActivities($users);

        return view('pages.admin.admin-dashboard', compact('users', 'totalUsers', 'activities'));
    }
}
