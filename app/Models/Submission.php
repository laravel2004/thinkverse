<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'assignment_id', 'user_id', 'student_name', 'file_path',
        'status', 'score', 'feedback', 'submitted_at'
    ];

    public function getStudentDisplayNameAttribute(): string
    {
        return $this->user?->name ?? $this->student_name ?? 'Pengunjung';
    }

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
        ];
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
