<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * SQLite: Gestion des suppressions en cascade manuelle
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($project) {
            // Supprimer manuellement les tâches associées
            // car SQLite peut avoir des problèmes avec ON DELETE CASCADE
            $project->tasks()->delete();
        });
    }
}