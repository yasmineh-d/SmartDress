<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Vetement;
use App\Models\Tenue;
use App\Services\AdminDashboardService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminDashboardServiceTest extends TestCase
{
    use RefreshDatabase;

    private AdminDashboardService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AdminDashboardService();
    }

    /** @test */
    public function it_can_count_total_users()
    {
        User::factory()->count(3)->create();

        $this->assertEquals(3, $this->service->getTotalUsersCount());
    }

    /** @test */
    public function it_can_count_total_clothes()
    {
        $user = User::factory()->create();
        
        Vetement::create(['nom' => 'T-shirt', 'categorie' => 'Hauts', 'user_id' => $user->id]);
        Vetement::create(['nom' => 'Jean', 'categorie' => 'Bas', 'user_id' => $user->id]);

        $this->assertEquals(2, $this->service->cloneAllClothesCount());
    }

    /** @test */
    public function it_can_count_total_outfits()
    {
        $user = User::factory()->create();
        
        Tenue::create(['nom' => 'Look 1', 'user_id' => $user->id]);
        Tenue::create(['nom' => 'Look 2', 'user_id' => $user->id]);

        $this->assertEquals(2, $this->service->getTotalOutfitsCount());
    }

    /** @test */
    public function it_can_calculate_average_clothes_per_user()
    {
        // 2 utilisateurs
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // 5 vêtements au total (3 pour user1, 2 pour user2)
        Vetement::create(['nom' => 'V1', 'categorie' => 'Hauts', 'user_id' => $user1->id]);
        Vetement::create(['nom' => 'V2', 'categorie' => 'Hauts', 'user_id' => $user1->id]);
        Vetement::create(['nom' => 'V3', 'categorie' => 'Hauts', 'user_id' => $user1->id]);
        
        Vetement::create(['nom' => 'V4', 'categorie' => 'Hauts', 'user_id' => $user2->id]);
        Vetement::create(['nom' => 'V5', 'categorie' => 'Hauts', 'user_id' => $user2->id]);

        // Moyenne : 5 vêtements / 2 utilisateurs = 2.5
        $this->assertEquals(2.5, $this->service->getAverageClothesPerUser());
    }

    /** @test */
    public function it_returns_zero_average_if_no_users_exist()
    {
        // Base de données vide
        $this->assertEquals(0.0, $this->service->getAverageClothesPerUser());
    }
}
