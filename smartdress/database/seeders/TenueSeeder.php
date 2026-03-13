<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tenue;
use App\Models\Vetement;
use Illuminate\Database\Seeder;

class TenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'user@smartdress.com')->first();
        if (!$user) return;

        // Créer une tenue "Casual Été"
        $tenue1 = $user->tenues()->create([
            'nom' => 'Look Casual Été',
            'meteo_adaptee' => 'Soleil, 25°C',
            'conseil_ia' => 'Une tenue légère et confortable pour vos sorties quotidiennes.',
        ]);

        // Sélectionner quelques vêtements appropriés
        $vetementsEte = Vetement::whereIn('nom', ['T-shirt blanc basique', 'Short en jean', 'Sandales en cuir'])->pluck('id');
        $tenue1->vetements()->sync($vetementsEte);

        // Créer une tenue "Hiver Chic"
        $tenue2 = $user->tenues()->create([
            'nom' => 'Hiver Classique',
            'meteo_adaptee' => 'Froid, 5°C',
            'conseil_ia' => 'Restez au chaud avec style grâce à ce manteau long.',
        ]);

        $vetementsHiver = Vetement::whereIn('nom', ['Pull en laine beige', 'Jean bleu slim', 'Bottes en cuir marron', 'Manteau long gris'])->pluck('id');
        $tenue2->vetements()->sync($vetementsHiver);
    }
}
