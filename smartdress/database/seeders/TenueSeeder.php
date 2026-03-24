<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tenue;
use App\Models\Vetement;
use Illuminate\Database\Seeder;

class TenueSeeder extends Seeder
{
    /**
     * Crée des tenues et les associe à des vêtements
     */
    public function run(): void
    {
        // 🔹 Récupérer l'utilisateur
        $user = User::where('email', 'user@smartdress.com')->first();
        if (!$user)
            return;

        // 👕 Création ou récupération d'une tenue été
        $tenue1 = $user->tenues()->firstOrCreate(
            ['nom' => 'Look Casual Été'],
            [
                'meteo_adaptee' => 'Soleil, 25°C',
                'conseil_ia' => 'Tenue légère et confortable.',
            ]
        );

        // 🔹 Récupérer les vêtements correspondants
        $vetementsEte = Vetement::whereIn('nom', [
            'T-shirt blanc basique',
            'Short en jean',
            'Sandales en cuir'
        ])->pluck('id');

        // 🔗 Associer vêtements à la tenue
        $tenue1->vetements()->sync($vetementsEte);

        // ❄️ Création ou récupération d'une tenue hiver
        $tenue2 = $user->tenues()->firstOrCreate(
            ['nom' => 'Hiver Classique'],
            [
                'meteo_adaptee' => 'Froid, 5°C',
                'conseil_ia' => 'Restez au chaud avec style.',
            ]
        );

        $vetementsHiver = Vetement::whereIn('nom', [
            'Pull en laine beige',
            'Jean bleu slim',
            'Bottes en cuir marron',
            'Manteau long gris'
        ])->pluck('id');

        // 🔗 Associer vêtements à la tenue hiver
        $tenue2->vetements()->sync($vetementsHiver);
    }
}