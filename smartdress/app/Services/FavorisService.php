<?php

namespace App\Services;

use App\Models\Favoris;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;

class FavorisService
{
    /**
     * Retourne tous les favoris avec leurs relations.
     */
    public function getAllWithRelations(): Collection
    {
        return Favoris::with(['vetement', 'tenue'])->get();
    }

    /**
    public function getForUser(User $user): Collection
    {
        return $user->favoris()
            ->whereNotNull('vetement_id')
            ->with(['vetement', 'tenue'])
            ->latest()
            ->get();
    }

    /**
     * Retourne un favori avec ses relations.
     */
    public function findWithRelations(int $id): Favoris
    {
        return Favoris::with(['vetement', 'tenue'])->findOrFail($id);
    }

    /**
     * Vérifie qu'un favori pointe vers un vêtement ou une tenue.
     *
     * @param array<string, mixed> $data
     */
    public function hasTarget(array $data): bool
    {
        return !empty($data['vetement_id']) || !empty($data['tenue_id']);
    }

    /**
     * Vérifie si le favori existe déjà.
     *
     * @param array<string, mixed> $data
     */
    public function existsForUser(User $user, array $data): bool
    {
        return Favoris::where('user_id', $user->id)
            ->where('vetement_id', $data['vetement_id'] ?? null)
            ->where('tenue_id', $data['tenue_id'] ?? null)
            ->exists();
    }

    /**
     * Crée un favori pour un utilisateur.
     *
     * @param array<string, mixed> $data
     */
    public function createForUser(User $user, array $data): Favoris
    {
        return Favoris::create([
            'user_id' => $user->id,
            'vetement_id' => $data['vetement_id'] ?? null,
            'tenue_id' => $data['tenue_id'] ?? null,
        ]);
    }

    /**
     * Crée un favori depuis les données API.
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data): Favoris
    {
        return Favoris::create($data);
    }

    /**
     * Supprime un favori appartenant à l'utilisateur.
     *
     * @throws AuthorizationException
     */
    public function deleteForUser(int $id, User $user): void
    {
        $favori = Favoris::findOrFail($id);

        if ($favori->user_id !== $user->id) {
            throw new AuthorizationException('Forbidden');
        }

        $favori->delete();
    }

    /**
     * Supprime un favori.
     */
    public function delete(Favoris $favori): void
    {
        $favori->delete();
    }
}
