<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * Tente de connecter l'utilisateur.
     *
     * @param array<string, string> $credentials
     */
    public function attemptLogin(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }

    /**
     * Retourne l'utilisateur connecté.
     */
    public function user(): ?User
    {
        return Auth::user();
    }

    /**
     * Régénère la session après connexion.
     */
    public function regenerateSession(Request $request): void
    {
        $request->session()->regenerate();
    }

    /**
     * Retourne le chemin de redirection selon le rôle.
     */
    public function redirectPathFor(User $user): string
    {
        return $user->hasRole('admin') ? '/admin' : '/dashboard';
    }

    /**
     * Déconnecte l'utilisateur et invalide sa session.
     */
    public function logout(Request $request): void
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
