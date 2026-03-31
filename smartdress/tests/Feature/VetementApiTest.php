<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vetement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VetementApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_the_list_of_clothes(): void
    {
        $user = User::factory()->create();

        Vetement::create([
            'nom' => 'Chemise',
            'categorie' => 'Hauts',
            'couleur' => 'Bleu',
            'saison' => 'Printemps',
            'style' => 'Chic',
            'user_id' => $user->id,
        ]);

        $response = $this->getJson('/api/vetements');

        $response->assertOk()
            ->assertJsonPath('data.0.nom', 'Chemise');
    }

    /** @test */
    public function it_creates_a_clothing_item_in_database(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/vetements', [
            'nom' => 'Jean',
            'categorie' => 'Bas',
            'couleur' => 'Noir',
            'saison' => 'Toutes',
            'style' => 'Casual',
            'user_id' => $user->id,
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.nom', 'Jean');

        $this->assertDatabaseHas('vetements', [
            'nom' => 'Jean',
            'categorie' => 'Bas',
            'user_id' => $user->id,
        ]);
    }
}
