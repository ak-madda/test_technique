<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('PRAGMA foreign_keys = OFF;');
        
        // Clear existing data
        DB::table('users')->delete();
        DB::table('projects')->delete();
        DB::table('tasks')->delete();
        
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now()
        ]);

        // Create a sample project
        $project = Project::create([
            'name' => 'Sample Project',
            'description' => 'This is a sample project to get you started.',
            'user_id' => $admin->id
        ]);

        // Create sample tasks
        Task::create([
            'title' => 'First Task',
            'description' => 'This is your first task',
            'status' => 'todo',
            'project_id' => $project->id,
            'assigned_to' => $admin->id
        ]);

        // Re-enable foreign key checks
        DB::statement('PRAGMA foreign_keys = ON;');
    }
}