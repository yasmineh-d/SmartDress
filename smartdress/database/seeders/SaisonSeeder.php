<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaisonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $saisons = ['printemps', 'ete', 'automne', 'hiver'];

        foreach ($saisons as $saison) {
            \App\Models\Saison::firstOrCreate(['nom' => $saison]);
        }
    }
}
