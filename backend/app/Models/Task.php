<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'assigned_to',
        'title',
        'description',
        'priority',
        'status',
        'progress',
        'deadline',

        'started_at',
        'finished_at',
        'attachment'
    ];

    // 🔥 RELASI KE USER (yang ngerjain task)
    public function assignedToUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // 🔥 RELASI KE PROJECT
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // 🔥 RELASI KE COMMENTS
    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}