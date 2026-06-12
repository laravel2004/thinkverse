<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index(Assignment $assignment)
    {
        $submissions = $assignment->submissions()->with('user')->orderBy('created_at', 'desc')->get();
        $course = $assignment->course;
        return view('admin.submissions.index', compact('assignment', 'submissions', 'course'));
    }

    public function update(Request $request, Submission $submission)
    {
        $data = $request->validate([
            'grade' => 'nullable|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $data['status'] = 'graded';
        $data['graded_at'] = now();

        $submission->update($data);

        return back()->with('success', 'Nilai dan umpan balik berhasil disimpan.');
    }
}
