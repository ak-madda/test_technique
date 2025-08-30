<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'project_id',
        'assigned_to',
        'created_by',
        'due_date'
    ];

    protected $casts = [
        // SQLite gère différemment les dates
        'due_date' => 'datetime:Y-m-d H:i:s',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * SQLite: Valider que les enum sont corrects
     */
    public function setStatusAttribute($value)
    {
        $allowed = ['pending', 'in_progress', 'completed'];
        if (!in_array($value, $allowed)) {
            throw new \InvalidArgumentException("Status must be one of: " . implode(', ', $allowed));
        }
        $this->attributes['status'] = $value;
    }

    public function setPriorityAttribute($value)
    {
        $allowed = ['low', 'medium', 'high'];
        if (!in_array($value, $allowed)) {
            throw new \InvalidArgumentException("Priority must be one of: " . implode(', ', $allowed));
        }
        $this->attributes['priority'] = $value;
    }
}