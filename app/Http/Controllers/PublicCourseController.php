<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;

class PublicCourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('status', 'published')->orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(12);
        return view('pages.courses', compact('courses'));
    }

    public function show(Course $course)
    {
        if ($course->status !== 'published') {
            abort(404);
        }

        $course->load(['lessons' => function($q) {
            $q->where('status', 'published')->orderBy('sort_order');
        }]);

        $firstLesson = $course->lessons->whereNull('parent_id')->first();

        return view('pages.courses.show', compact('course', 'firstLesson'));
    }

    public function lesson(Course $course, Lesson $lesson)
    {
        if ($course->status !== 'published' || $lesson->status !== 'published' || $lesson->course_id !== $course->id) {
            abort(404);
        }

        $lesson->load(['contentBlocks' => function($q) {
            $q->orderBy('sort_order');
        }]);

        $course->load(['lessons' => function($q) {
            $q->where('status', 'published')->orderBy('sort_order');
        }]);

        // Load assignments if any
        $assignments = $lesson->assignments()->where('is_active', true)->get();
        if ($assignments->isEmpty()) {
            $assignments = $course->assignments()->whereNull('lesson_id')->where('is_active', true)->get();
        }

        $comments = $course->comments()->whereNull('parent_id')->with('user', 'replies.user')->orderBy('created_at', 'desc')->get();

        return view('pages.courses.lesson', compact('course', 'lesson', 'assignments', 'comments'));
    }
}
