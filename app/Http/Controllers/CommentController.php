<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $data = $request->validate([
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $data['course_id'] = $course->id;
        $data['user_id'] = auth()->id();
        $data['status'] = 'visible';

        Comment::create($data);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}
