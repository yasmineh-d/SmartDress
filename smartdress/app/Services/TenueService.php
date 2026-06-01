<?php

namespace App\Services;

use App\Models\Tenue;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class TenueService
{
    /**
     * Retourne toutes les tenues avec leurs vêtements.
     */
    public function getAllWithClothes(): Collection
    {
        return Tenue::with('vetements')->get();
    }

    /**
     * Retourne les tenues d'un utilisateur.
     */
    public function getForUser(User $user): Collection
    {
        return $user->tenues()->latest()->get();
    }

    /**
     * Retourne les vêtements disponibles pour composer une tenue.
     */
    public function getAvailableClothesForUser(User $user): Collection
    {
        return $user->vetements()->latest()->get();
    }

    /**
     * Crée une tenue pour un utilisateur et synchronise ses vêtements.
     *
     * @param array<string, mixed> $data
     */
    public function createForUser(User $user, array $data): Tenue
    {
        $vetements = $data['vetements'] ?? [];
        unset($data['vetements']);

        $tenue = $user->tenues()->create($data);
        $this->syncClothes($tenue, $vetements);

        return $tenue->load('vetements');
    }

    /**
     * Crée une tenue depuis les données API.
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data): Tenue
    {
        $vetements = $data['vetements'] ?? [];
        unset($data['vetements']);

        $tenue = Tenue::create($data);
        $this->syncClothes($tenue, $vetements);

        return $tenue->load('vetements');
    }

    /**
     * Retourne une tenue précise avec ses vêtements.
     */
    public function findWithClothes(int $id): Tenue
    {
        return Tenue::with('vetements')->findOrFail($id);
    }

    /**
     * Met à jour une tenue et ses vêtements.
     *
     * @param array<string, mixed> $data
     */
    public function update(Tenue $tenue, array $data): Tenue
    {
        $vetements = $data['vetements'] ?? null;
        unset($data['vetements']);

        $tenue->update($data);

        if ($vetements !== null) {
            $this->syncClothes($tenue, $vetements);
        }

        return $tenue->load('vetements');
    }

    /**
     * Supprime une tenue avec ses relations.
     */
    public function delete(Tenue $tenue): void
    {
        $tenue->vetements()->detach();
        $tenue->delete();
    }

    /**
     * @param array<int, int> $vetementIds
     */
    private function syncClothes(Tenue $tenue, array $vetementIds): void
    {
        if ($vetementIds !== []) {
            $tenue->vetements()->sync($vetementIds);
        }
    }
}
