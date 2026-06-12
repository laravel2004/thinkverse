<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentBlock extends Model
{
    protected $fillable = [
        'lesson_id', 'type', 'payload', 'sort_order'
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
        ];
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
