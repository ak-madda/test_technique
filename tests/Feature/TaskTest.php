<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_task()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);
        
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson("/api/projects/{$project->id}/tasks", [
                'title' => 'Test Task',
                'description' => 'Test Description',
                'status' => 'pending',
                'priority' => 'medium',
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'title' => 'Test Task',
                'description' => 'Test Description',
                'status' => 'pending',
                'priority' => 'medium',
                'project_id' => $project->id,
            ]);
    }

    public function test_user_can_update_task_status()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);
        $task = Task::factory()->create([
            'project_id' => $project->id,
            'created_by' => $user->id,
        ]);
        
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->patchJson("/api/tasks/{$task->id}/status", [
                'status' => 'in_progress',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'in_progress',
            ]);
    }
}