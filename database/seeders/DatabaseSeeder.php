<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear all tables
        DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('personal_access_tokens')->truncate();
        DB::table('tasks')->truncate();
        DB::table('projects')->truncate();
        DB::table('users')->truncate();
        DB::statement('PRAGMA foreign_keys = ON;');

        // Create admin user with correct credentials
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password', // Will be hashed by the model
            'email_verified_at' => now()
        ]);

        // Create a test project
        $project = Project::create([
            'name' => 'Test Project',
            'description' => 'A test project',
            'user_id' => $admin->id
        ]);

        // Create a test task
        Task::create([
            'title' => 'Test Task',
            'description' => 'A test task',
            'status' => 'todo',
            'project_id' => $project->id,
            'assigned_to' => $admin->id
        ]);
    }
}