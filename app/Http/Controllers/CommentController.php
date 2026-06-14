<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $data = $request->validate([
            'guest_name' => 'required|string|min:2|max:100',
            'body' => 'required|string|min:3|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $data['course_id'] = $course->id;
        $data['user_id'] = auth()->id();
        $data['status'] = 'visible';

        Comment::create($data);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}
