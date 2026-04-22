<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::first();
        $tenues = \App\Models\Tenue::all();

        if ($user && $tenues->count() > 0) {
            foreach ($tenues as $tenue) {
                \App\Models\Commentaire::create([
                    'contenu' => 'Super tenue pour aujourd\'hui !',
                    'user_id' => $user->id,
                    'tenue_id' => $tenue->id,
                ]);

                \App\Models\Commentaire::create([
                    'contenu' => 'J\'adore ce style !',
                    'user_id' => $user->id,
                    'tenue_id' => $tenue->id,
                ]);
            }
        }
    }
}
