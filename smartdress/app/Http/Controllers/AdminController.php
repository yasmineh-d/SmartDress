<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get()->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->roles->first()?->nom ?? 'User',
                'status' => 'Actif',
            ];
        });

        $totalUsers = $users->count();
        
        $firstUser = $users->first();
        $activities = [
            [
                'id' => 1, 
                'initial' => $firstUser ? substr($firstUser['name'], 0, 2) : 'YA', 
                'name' => $firstUser ? $firstUser['name'] : 'Admin', 
                'action' => 'Connexion système', 
                'time' => 'Maintenant'
            ],
        ];

        return view('pages.admin.admin-dashboard', compact('users', 'totalUsers', 'activities'));
    }
}
