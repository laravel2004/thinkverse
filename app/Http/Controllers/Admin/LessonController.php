<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    public function index(Course $course)
    {
        $lessons = $course->lessons()->whereNull('parent_id')->with('children')->orderBy('sort_order')->get();
        return view('admin.lessons.index', compact('course', 'lessons'));
    }

    public function create(Course $course)
    {
        //
    }

    public function store(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:lessons,id',
        ]);

        $parentId = $data['parent_id'] ?? null;
        $data['parent_id'] = $parentId;
        $data['slug'] = Str::slug($data['title']) . '-' . uniqid();
        $data['course_id'] = $course->id;
        $data['sort_order'] = Lesson::where('course_id', $course->id)
            ->where('parent_id', $parentId)
            ->max('sort_order') + 1;

        Lesson::create($data);

        return back()->with('success', 'Materi berhasil ditambahkan!');
    }

    public function show(Lesson $lesson)
    {
        // Go to content builder
        return redirect()->route('admin.lessons.edit', $lesson);
    }

    public function edit(Lesson $lesson)
    {
        $lesson->load(['contentBlocks' => function($q) {
            $q->orderBy('sort_order');
        }]);
        return view('admin.lessons.edit', compact('lesson'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:draft,published',
            'excerpt' => 'nullable|string',
        ]);

        $lesson->update($data);
        return back()->with('success', 'Detail materi diperbarui!');
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return back()->with('success', 'Materi dihapus!');
    }
}
