<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Models\User;
use App\Models\Vetement;
use App\Services\WardrobeService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WardrobeServiceTest extends TestCase
{
    use RefreshDatabase;

    private WardrobeService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new WardrobeService();
    }

    /** @test */
    public function it_returns_true_if_user_has_enough_clothes()
    {
        $user = User::factory()->create();

        Vetement::create(['nom' => 'T-shirt', 'categorie' => 'Hauts', 'user_id' => $user->id, 'couleur' => 'Blanc', 'saison' => 'Ete', 'style' => 'Casual']);
        Vetement::create(['nom' => 'Jean', 'categorie' => 'Bas', 'user_id' => $user->id, 'couleur' => 'Bleu', 'saison' => 'Toutes', 'style' => 'Casual']);
        Vetement::create(['nom' => 'Baskets', 'categorie' => 'Chaussures', 'user_id' => $user->id, 'couleur' => 'Noir', 'saison' => 'Toutes', 'style' => 'Sport']);

        $this->assertTrue($this->service->hasEnoughClothesForOutfit($user));
    }

    /** @test */
    public function it_returns_false_if_user_misses_a_category()
    {
        $user = User::factory()->create();

        // L'utilisateur n'a pas de chaussures
        Vetement::create(['nom' => 'T-shirt', 'categorie' => 'Hauts', 'user_id' => $user->id, 'couleur' => 'Blanc', 'saison' => 'Ete', 'style' => 'Casual']);
        Vetement::create(['nom' => 'Jean', 'categorie' => 'Bas', 'user_id' => $user->id, 'couleur' => 'Bleu', 'saison' => 'Toutes', 'style' => 'Casual']);

        $this->assertFalse($this->service->hasEnoughClothesForOutfit($user));
    }
}
