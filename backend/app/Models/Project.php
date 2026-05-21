<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'goal',
        'start_date',
        'deadline',
        'status'
    ];

    // relasi ke tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // relasi ke documents
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}