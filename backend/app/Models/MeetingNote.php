<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingNote extends Model
{
    protected $fillable = [
        'title',
        'notes',
        'attachment',
        'meeting_date',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}