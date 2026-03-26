<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoteLog extends Model
{
    protected $fillable = [
        'note_id',
        'actor_user_id',
        'action',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'meta' => 'array',
        ];
    }
}

