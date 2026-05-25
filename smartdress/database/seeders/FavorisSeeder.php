<?php

namespace Database\Seeders;

use App\Models\Favoris;
use App\Models\Tenue;
use App\Models\User;
use App\Models\Vetement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class FavorisSeeder extends Seeder
{
    /**
     * Cree des favoris depuis un CSV.
     */
    public function run(): void
    {
        $csvPath = database_path('data/favoris.csv');

        if (!File::exists($csvPath)) {
            return;
        }

        $lines = explode("\n", File::get($csvPath));
        $header = str_getcsv(array_shift($lines));

        foreach ($lines as $line) {
            if (empty(trim($line))) {
                continue;
            }

            $row = str_getcsv($line);
            $data = array_combine($header, $row);

            if (!$data || empty($data['user_email'])) {
                continue;
            }

            $user = User::where('email', $data['user_email'])->first();
            $vetement = !empty($data['vetement_nom'])
                ? Vetement::where('nom', $data['vetement_nom'])->first()
                : null;
            $tenue = !empty($data['tenue_nom'])
                ? Tenue::where('nom', $data['tenue_nom'])->first()
                : null;

            if (!$user || (!$vetement && !$tenue)) {
                continue;
            }

            Favoris::firstOrCreate([
                'user_id' => $user->id,
                'vetement_id' => $vetement?->id,
                'tenue_id' => $tenue?->id,
            ]);
        }
    }
}
