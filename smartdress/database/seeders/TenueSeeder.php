<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TenueSeeder extends Seeder
{
    /**
     * Cree des tenues depuis un CSV.
     */
    public function run(): void
    {
        $csvPath = database_path('data/tenues.csv');

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

            if (!$data || empty($data['user_email']) || empty($data['nom'])) {
                continue;
            }

            $user = User::where('email', $data['user_email'])->first();
            if (!$user) {
                continue;
            }

            $user->tenues()->updateOrCreate(
                ['nom' => $data['nom']],
                [
                    'meteo_adaptee' => $data['meteo_adaptee'] ?? null,
                    'conseil_ia' => $data['conseil_ia'] ?? null,
                ]
            );
        }
    }
}
