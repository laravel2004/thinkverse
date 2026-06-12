<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index(Course $course)
    {
        $assignments = $course->assignments()->with('lesson')->orderBy('created_at', 'desc')->get();
        return view('admin.assignments.index', compact('course', 'assignments'));
    }

    public function create(Course $course)
    {
        return view('admin.assignments.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'lesson_id' => 'nullable|exists:lessons,id',
            'instruction' => 'nullable|string',
            'is_active' => 'boolean',
            'due_at' => 'nullable|date',
        ]);

        $data['course_id'] = $course->id;
        $data['is_active'] = $request->has('is_active');

        Assignment::create($data);

        return redirect()->route('admin.courses.assignments.index', $course)->with('success', 'Tugas berhasil dibuat!');
    }

    public function edit(Assignment $assignment)
    {
        $course = $assignment->course;
        return view('admin.assignments.create', compact('course', 'assignment'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'lesson_id' => 'nullable|exists:lessons,id',
            'instruction' => 'nullable|string',
            'is_active' => 'boolean',
            'due_at' => 'nullable|date',
        ]);

        $data['is_active'] = $request->has('is_active');

        $assignment->update($data);

        return redirect()->route('admin.courses.assignments.index', $assignment->course_id)->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroy(Assignment $assignment)
    {
        $assignment->delete();
        return back()->with('success', 'Tugas dihapus!');
    }
}
