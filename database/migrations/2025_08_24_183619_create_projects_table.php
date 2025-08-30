<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            
            // SQLite gère différemment les foreign keys
            if (DB::connection()->getDriverName() === 'sqlite') {
                $table->unsignedBigInteger('user_id');
            } else {
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
            }
            
            $table->timestamps();
        });

        // Index pour SQLite
        if (DB::connection()->getDriverName() === 'sqlite') {
            Schema::table('projects', function (Blueprint $table) {
                $table->index('user_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};