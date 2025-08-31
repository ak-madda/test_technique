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
        'project_id',
        'assigned_to'
    ];

    // Define allowed status values as a constant
    const ALLOWED_STATUSES = ['todo', 'in_progress', 'done'];

    public function setStatusAttribute($value)
    {
        if (!in_array($value, self::ALLOWED_STATUSES)) {
            throw new \InvalidArgumentException("Status must be one of: " . implode(', ', self::ALLOWED_STATUSES));
        }
        $this->attributes['status'] = $value;
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}