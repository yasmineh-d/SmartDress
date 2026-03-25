<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Tenue;
use App\Services\OutfitRecommendationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OutfitRecommendationServiceTest extends TestCase
{
    use RefreshDatabase;

    private OutfitRecommendationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new OutfitRecommendationService();
    }

    /** @test */
    public function it_recommends_a_summer_outfit_when_it_is_warm()
    {
        $user = User::factory()->create();

        $ete = Tenue::create([
            'nom' => 'Mon Look Été',
            'user_id' => $user->id,
            'meteo_adaptee' => 'Soleil',
            'conseil_ia' => 'Léger'
        ]);

        $hiver = Tenue::create([
            'nom' => 'Mon Look Hiver',
            'user_id' => $user->id,
            'meteo_adaptee' => 'Neige',
            'conseil_ia' => 'Chaud'
        ]);

        $recommendation = $this->service->getBestOutfit($user, 25);

        $this->assertEquals($ete->id, $recommendation->id);
    }

    /** @test */
    public function it_recommends_a_winter_outfit_when_it_is_cold()
    {
        $user = User::factory()->create();

        $ete = Tenue::create([
            'nom' => 'Mon Look Été',
            'user_id' => $user->id,
            'meteo_adaptee' => 'Soleil',
            'conseil_ia' => 'Léger'
        ]);

        $hiver = Tenue::create([
            'nom' => 'Mon Look Hiver',
            'user_id' => $user->id,
            'meteo_adaptee' => 'Neige',
            'conseil_ia' => 'Chaud'
        ]);

        $recommendation = $this->service->getBestOutfit($user, 5);

        $this->assertEquals($hiver->id, $recommendation->id);
    }

    /** @test */
    public function it_returns_null_if_no_outfit_matches_the_weather()
    {
        $user = User::factory()->create();

        // Pas de tenues créées

        $recommendation = $this->service->getBestOutfit($user, 25);

        $this->assertNull($recommendation);
    }
}
