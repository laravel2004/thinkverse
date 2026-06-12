<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'course_id', 'parent_id', 'title', 'slug', 
        'excerpt', 'content', 'status', 'sort_order'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function parent()
    {
        return $this->belongsTo(Lesson::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Lesson::class, 'parent_id')->orderBy('sort_order');
    }

    public function contentBlocks()
    {
        return $this->hasMany(ContentBlock::class)->orderBy('sort_order');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
