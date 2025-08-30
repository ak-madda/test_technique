<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SqliteTest extends TestCase
{
    use RefreshDatabase;

    public function test_sqlite_database_works()
    {
        // Vérifier que nous utilisons bien SQLite
        $connection = config('database.default');
        $this->assertEquals('sqlite', $connection, 'Should be using SQLite database');
        
        // Vérifier que le fichier de base de données existe
        $databasePath = config('database.connections.sqlite.database');
        $this->assertFileExists($databasePath, 'SQLite database file should exist');
        
        // Test simple de création d'utilisateur
        $user = \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);
        
        $this->assertNotNull($user->id, 'User should be created successfully');
        $this->assertEquals('Test User', $user->name);
    }

    public function test_project_creation()
    {
        $user = \App\Models\User::factory()->create();
        
        $project = \App\Models\Project::create([
            'name' => 'Test Project',
            'description' => 'Test Description',
            'user_id' => $user->id
        ]);
        
        $this->assertNotNull($project->id);
        $this->assertEquals('Test Project', $project->name);
        $this->assertEquals($user->id, $project->user_id);
    }
}