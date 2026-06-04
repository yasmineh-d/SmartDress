<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vetement;
use App\Models\Planning;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanningTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_planning()
    {
        $response = $this->get('/planning');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_users_can_access_planning_view()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/planning');

        $response->assertOk();
        $response->assertViewIs('planning.index');
        $response->assertViewHas('semaine');
    }

    /** @test */
    public function user_can_store_a_planned_outfit_via_web_form()
    {
        $user = User::factory()->create();
        $top = Vetement::create([
            'nom' => 'Sweat Vert',
            'categorie' => 'hauts',
            'user_id' => $user->id,
        ]);
        $bottom = Vetement::create([
            'nom' => 'Jean Cargo',
            'categorie' => 'bas',
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->post('/planning', [
            'vetement_top_id' => $top->id,
            'vetement_bottom_id' => $bottom->id,
            'date_planning' => today()->format('Y-m-d'),
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('plannings', [
            'user_id' => $user->id,
            'vetement_top_id' => $top->id,
            'vetement_bottom_id' => $bottom->id,
        ]);
    }

    /** @test */
    public function user_can_store_a_planned_outfit_via_ajax_request()
    {
        $user = User::factory()->create();
        $top = Vetement::create([
            'nom' => 'T-Shirt Blanc',
            'categorie' => 'hauts',
            'user_id' => $user->id,
        ]);
        $bottom = Vetement::create([
            'nom' => 'Short Beige',
            'categorie' => 'bas',
            'user_id' => $user->id,
        ]);

        // Sending short keys (top_id, bottom_id) as sent by JavaScript fetch
        $response = $this->actingAs($user)->postJson('/planning', [
            'top_id' => $top->id,
            'bottom_id' => $bottom->id,
        ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'message' => 'Tenue ajoutée au planning du jour !',
        ]);

        $this->assertDatabaseHas('plannings', [
            'user_id' => $user->id,
            'vetement_top_id' => $top->id,
            'vetement_bottom_id' => $bottom->id,
        ]);
    }

    /** @test */
    public function user_can_delete_a_planned_outfit()
    {
        $user = User::factory()->create();
        $top = Vetement::create([
            'nom' => 'Veste',
            'categorie' => 'hauts',
            'user_id' => $user->id,
        ]);
        $bottom = Vetement::create([
            'nom' => 'Pantalon',
            'categorie' => 'bas',
            'user_id' => $user->id,
        ]);

        $planning = Planning::create([
            'user_id' => $user->id,
            'vetement_top_id' => $top->id,
            'vetement_bottom_id' => $bottom->id,
            'date_planning' => today(),
        ]);

        $response = $this->actingAs($user)->delete("/planning/{$planning->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('plannings', [
            'id' => $planning->id,
        ]);
    }
}
