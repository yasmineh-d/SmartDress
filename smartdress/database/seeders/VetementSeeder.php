<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vetement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class VetementSeeder extends Seeder
{
    /**
     * Ajoute des vêtements à partir d’un fichier CSV
     */
    public function run(): void
    {
        // 🔹 Récupérer l'utilisateur de test
        $user = User::where('email', 'user@smartdress.com')->first();
        if (!$user)
            return; // arrêter si utilisateur introuvable

        // 🔹 Vérifier si le fichier CSV existe
        $csvPath = database_path('data/vetements.csv');
        if (!File::exists($csvPath))
            return;

        // 🔹 Lire le contenu du fichier
        $csvData = File::get($csvPath);

        // 🔹 Transformer le contenu en tableau de lignes
        $lines = explode("\n", $csvData);

        // 🔹 Récupérer les noms des colonnes (header)
        $header = str_getcsv(array_shift($lines));

        // 🔄 Parcours de chaque ligne du CSV
        foreach ($lines as $line) {
            if (empty(trim($line)))
                continue; // ignorer lignes vides

            $row = str_getcsv($line); // transformer la ligne en tableau
            $data = array_combine($header, $row); // associer colonnes et valeurs

            // 👕 Créer le vêtement s'il n'existe pas
            Vetement::firstOrCreate(
                [
                    'nom' => $data['nom'],
                    'user_id' => $user->id,
                ],
                [
                    'categorie' => $data['categorie'],
                    'couleur' => $data['couleur'],
                    'saison' => $data['saison'],
                    'style' => $data['style'],
                ]
            );
        }
    }
}