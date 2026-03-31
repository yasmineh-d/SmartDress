<?php

namespace App\Services;

use App\Models\Vetement;
use Illuminate\Database\Eloquent\Collection;

class VetementService
{
    /**
     * Retourne la liste complète des vêtements.
     */
    public function getAll(): Collection
    {
        return Vetement::query()
            ->latest()
            ->get();
    }

    /**
     * Crée un vêtement en base de données.
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data): Vetement
    {
        return Vetement::create($data);
    }

    /**
     * Retourne un vêtement précis.
     */
    public function find(int $id): Vetement
    {
        return Vetement::query()->findOrFail($id);
    }

    /**
     * Met à jour un vêtement existant.
     *
     * @param array<string, mixed> $data
     */
    public function update(Vetement $vetement, array $data): Vetement
    {
        $vetement->update($data);

        return $vetement->refresh();
    }

    /**
     * Supprime un vêtement.
     */
    public function delete(Vetement $vetement): void
    {
        $vetement->delete();
    }
}
