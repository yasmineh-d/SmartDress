<?php

namespace App\Services;

use App\Models\User;
use App\Models\Vetement;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
     * Retourne les vêtements d'un utilisateur.
     */
    public function getForUser(User $user, bool $withPhotos = false): Collection
    {
        $query = $user->vetements()->latest();

        if ($withPhotos) {
            $query->with('photos');
        }

        return $query->get();
    }

    /**
     * Crée un vêtement en base de données.
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data): Vetement
    {
        $saisonInput = $data['saison'] ?? null;
        unset($data['saison']);

        $vetement = Vetement::create($data);

        $this->syncSaisons($vetement, $saisonInput);

        return $vetement->load(['photos', 'saisons']);
    }

    /**
     * Crée un vêtement pour l'utilisateur connecté et associe une photo si fournie.
     *
     * @param array<string, mixed> $data
     */
    public function createForUser(User $user, array $data, ?UploadedFile $photo = null): Vetement
    {
        $saisonInput = $data['saison'] ?? null;
        unset($data['photo'], $data['saison']);

        $vetement = $user->vetements()->create($data);

        $this->syncSaisons($vetement, $saisonInput);

        if ($photo) {
            $path = $photo->store('photos', 'public');

            $vetement->photos()->create([
                'url' => $path,
                'dateUpload' => now(),
            ]);
        }

        return $vetement->load(['photos', 'saisons']);
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
        $saisonInput = $data['saison'] ?? null;
        unset($data['saison']);

        $vetement->update($data);

        $this->syncSaisons($vetement, $saisonInput);

        return $vetement->refresh()->load('saisons');
    }

    /**
     * Synchronise les saisons de l'input vers la relation pivot Many-to-Many.
     */
    private function syncSaisons(Vetement $vetement, mixed $saisonInput): void
    {
        if (empty($saisonInput)) {
            $vetement->saisons()->detach();
            return;
        }

        if (is_string($saisonInput)) {
            $saisonInput = explode(',', $saisonInput);
        }

        $saisonNames = array_map(function ($s) {
            // Uniformisation en minuscules et sans accents (ex: "Été" -> "ete")
            return strtolower(trim(str_replace(['É', 'é'], 'e', $s)));
        }, (array) $saisonInput);

        $saisonIds = \App\Models\Saison::whereIn('nom', $saisonNames)->pluck('id')->toArray();
        $vetement->saisons()->sync($saisonIds);
    }

    /**
     * Supprime un vêtement.
     */
    public function delete(Vetement $vetement): void
    {
        $vetement->delete();
    }

    /**
     * Supprime un vêtement avec ses photos et fichiers associés.
     */
    public function deleteWithPhotos(Vetement $vetement): void
    {
        $vetement->loadMissing('photos');

        foreach ($vetement->photos as $photo) {
            if (Storage::disk('public')->exists($photo->url)) {
                Storage::disk('public')->delete($photo->url);
            }
        }

        $vetement->photos()->delete();
        $vetement->delete();
    }
}
