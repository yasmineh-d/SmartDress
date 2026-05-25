<?php

namespace Database\Seeders;

use App\Models\Tenue;
use App\Models\Vetement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TenueVetementSeeder extends Seeder
{
    /**
     * Lie les tenues aux vetements depuis un CSV pivot.
     */
    public function run(): void
    {
        $csvPath = database_path('data/tenue_vetement.csv');

        if (!File::exists($csvPath)) {
            return;
        }

        $lines = explode("\n", File::get($csvPath));
        $header = str_getcsv(array_shift($lines));
        $relations = [];

        foreach ($lines as $line) {
            if (empty(trim($line))) {
                continue;
            }

            $row = str_getcsv($line);
            $data = array_combine($header, $row);

            if (!$data || empty($data['tenue_nom']) || empty($data['vetement_nom'])) {
                continue;
            }

            $relations[$data['tenue_nom']][] = $data['vetement_nom'];
        }

        foreach ($relations as $tenueNom => $vetementNoms) {
            $tenue = Tenue::where('nom', $tenueNom)->first();
            if (!$tenue) {
                continue;
            }

            $vetementIds = Vetement::whereIn('nom', array_unique($vetementNoms))->pluck('id')->all();

            if (!empty($vetementIds)) {
                $tenue->vetements()->sync($vetementIds);
            }
        }
    }
}
