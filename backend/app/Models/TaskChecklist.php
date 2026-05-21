<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskChecklist extends Model
{
    protected $fillable = [
        'task_id',
        'title',
        'is_done'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}