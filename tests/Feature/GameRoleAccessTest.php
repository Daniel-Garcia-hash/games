<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class GameRoleAccessTest extends TestCase
{
    use RefreshDatabase;

    private function gameData(): array
    {
        return ['game_name' => 'Testgame', 'platform' => 'PC', 'genre' => 'Puzzle', 'rating' => 8];
    }

    private function signInAs(string $role): void
    {
        Role::findOrCreate($role, 'web');
        $user = User::factory()->create();
        $user->assignRole($role);
        $this->actingAs($user);
    }

    private function assertManagementDenied(int $id): void
    {
        foreach (['/games/create', "/games/show/$id", "/games/edit/$id"] as $url) {
            $this->get($url)->assertForbidden();
        }
        foreach (['/games/store', "/games/update/$id", "/games/destroy/$id"] as $url) {
            $this->post($url, $this->gameData())->assertForbidden();
        }
        $this->assertDatabaseCount('games', 1);
        $this->assertDatabaseHas('games', ['id' => $id, 'game_name' => 'Original']);
    }

    public function test_customer_can_only_access_overview(): void
    {
        $game = Game::create(array_replace($this->gameData(), ['game_name' => 'Original']));
        $this->signInAs('klant');
        $this->get('/games')->assertOk()->assertSee('Original')->assertDontSee('/games/show/');
        $this->assertManagementDenied($game->id);
    }

    public function test_user_without_role_is_denied(): void
    {
        $game = Game::create(array_replace($this->gameData(), ['game_name' => 'Original']));
        $this->actingAs(User::factory()->create());
        $this->get('/games')->assertForbidden();
        $this->assertManagementDenied($game->id);
    }

    public function test_admin_can_access_all_game_pages_and_actions(): void
    {
        $game = Game::create($this->gameData());
        $this->signInAs('admin');
        foreach (['/games', '/games/create', "/games/show/$game->id", "/games/edit/$game->id"] as $url) {
            $this->get($url)->assertOk();
        }
        $this->post('/games/store', $this->gameData())->assertRedirect('/games');
        $this->assertDatabaseCount('games', 2);
        $this->post("/games/update/$game->id", array_replace($this->gameData(), ['game_name' => 'Updated']))->assertRedirect('/games');
        $this->assertDatabaseHas('games', ['id' => $game->id, 'game_name' => 'Updated']);
        $this->post("/games/destroy/$game->id")->assertRedirect('/games');
        $this->assertDatabaseMissing('games', ['id' => $game->id]);
    }

    public function test_guests_are_redirected_to_login(): void
    {
        foreach (['/games', '/games/create', '/games/show/1', '/games/edit/1'] as $url) {
            $this->get($url)->assertRedirect('/login');
        }
        foreach (['/games/store', '/games/update/1', '/games/destroy/1'] as $url) {
            $this->post($url, $this->gameData())->assertRedirect('/login');
        }
    }
}
