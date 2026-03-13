<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vetement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class VetementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'user@smartdress.com')->first();
        
        if (!$user) return;

        $csvPath = database_path('data/vetements.csv');
        if (!File::exists($csvPath)) return;

        $csvData = File::get($csvPath);
        $lines = explode("\n", $csvData);
        $header = str_getcsv(array_shift($lines));

        foreach ($lines as $line) {
            if (empty(trim($line))) continue;
            
            $row = str_getcsv($line);
            $data = array_combine($header, $row);
            
            Vetement::create([
                'nom' => $data['nom'],
                'categorie' => $data['categorie'],
                'couleur' => $data['couleur'],
                'saison' => $data['saison'],
                'style' => $data['style'],
                'user_id' => $user->id,
            ]);
        }
    }
}
