<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            
            // SQLite ne supporte pas nativement les enum, on utilise string à la place
            $table->string('status')->default('pending');
            $table->string('priority')->default('medium');
            
            // Gestion des clés étrangères pour SQLite
            if (DB::connection()->getDriverName() === 'sqlite') {
                $table->unsignedBigInteger('project_id');
                $table->unsignedBigInteger('assigned_to')->nullable();
                $table->unsignedBigInteger('created_by');
            } else {
                $table->foreignId('project_id')->constrained()->onDelete('cascade');
                $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
                $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            }
            
            $table->timestamp('due_date')->nullable();
            $table->timestamps();
        });

        // Ajout des index pour SQLite
        if (DB::connection()->getDriverName() === 'sqlite') {
            Schema::table('tasks', function (Blueprint $table) {
                $table->index('project_id');
                $table->index('assigned_to');
                $table->index('created_by');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};