<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadService
{
    /**
     * Gère le téléchargement et la sauvegarde de l'image d'un vêtement.
     * 
     * @param UploadedFile|null $image
     * @return string|null Retourne le chemin de l'image ou null.
     */
    public function uploadClothingImage(?UploadedFile $image): ?string
    {
        if (!$image || !$image->isValid()) {
            return null;
        }

        // Générer un nom de fichier unique sécurisé
        $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

        // Enregistrer l'image dans storage/app/public/clothes
        // Cela sera accessible publiquement via php artisan storage:link
        $path = $image->storeAs('clothes', $filename, 'public');

        return $path;
    }

    /**
     * Supprime une image du disque.
     * 
     * @param string|null $path
     * @return bool
     */
    public function deleteImage(?string $path): bool
    {
        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }
}
