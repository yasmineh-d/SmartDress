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

        // 👕 Création de nouvelles tenues pour l'ÉTÉ
        $tenueEte2 = $user->tenues()->firstOrCreate(
            ['nom' => 'Look Sport Été'],
            [
                'meteo_adaptee' => 'Soleil, chaud',
                'conseil_ia' => 'Parfait pour une balade estivale.',
            ]
        );
        $tenueEte2->vetements()->sync(Vetement::whereIn('nom', [
            'Polo rouge',
            'Short en jean',
            'Baskets blanches'
        ])->pluck('id'));

        $tenueEte3 = $user->tenues()->firstOrCreate(
            ['nom' => 'Soirée Été'],
            [
                'meteo_adaptee' => 'Doux, 20°C',
                'conseil_ia' => 'Décontracté mais habillé.',
            ]
        );
        $tenueEte3->vetements()->sync(Vetement::whereIn('nom', [
            'Chemise bleu ciel',
            'Pantalon chino kaki',
            'Baskets blanches'
        ])->pluck('id'));

        // ❄️ Création de nouvelles tenues pour l'HIVER
        $tenueHiver2 = $user->tenues()->firstOrCreate(
            ['nom' => 'Bureau Hiver'],
            [
                'meteo_adaptee' => 'Frais, 10°C',
                'conseil_ia' => 'Idéal pour le travail par temps frais.',
            ]
        );
        $tenueHiver2->vetements()->sync(Vetement::whereIn('nom', [
            'Chemise bleu ciel',
            'Pantalon chino kaki',
            'Veste en jean',
            'Bottes en cuir marron'
        ])->pluck('id'));

        $tenueHiver3 = $user->tenues()->firstOrCreate(
            ['nom' => 'Soirée Hiver'],
            [
                'meteo_adaptee' => 'Froid, Soirée',
                'conseil_ia' => 'Élégant et chaud pour sortir.',
            ]
        );
        $tenueHiver3->vetements()->sync(Vetement::whereIn('nom', [
            'T-shirt blanc basique',
            'Jupe noire',
            'Manteau long gris',
            'Escarpins noirs'
        ])->pluck('id'));
    }
}