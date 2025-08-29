<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_project()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/projects', [
                'name' => 'Test Project',
                'description' => 'Test Description',
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'name' => 'Test Project',
                'description' => 'Test Description',
                'user_id' => $user->id,
            ]);
    }

    public function test_user_can_view_their_projects()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        Project::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/projects');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_user_cannot_view_others_projects()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        $token = $user1->createToken('test-token')->plainTextToken;
        
        Project::factory()->create(['user_id' => $user2->id]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/projects');

        $response->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }
}