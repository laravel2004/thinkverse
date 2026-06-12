<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;

class SubmissionController extends Controller
{
    public function store(Request $request, Assignment $assignment)
    {
        $request->validate([
            'submission_file' => 'required|file|mimes:pdf|max:10240', // max 10MB PDF
        ]);

        if (!$assignment->is_active) {
            return back()->with('error', 'Tugas ini sudah tidak aktif.');
        }

        if ($assignment->due_at && $assignment->due_at->isPast()) {
            return back()->with('error', 'Waktu pengumpulan tugas sudah habis.');
        }

        $path = $request->file('submission_file')->store('submissions', 'public');

        Submission::updateOrCreate(
            ['assignment_id' => $assignment->id, 'user_id' => auth()->id()],
            ['file_path' => $path, 'status' => 'pending', 'submitted_at' => now()]
        );

        return back()->with('success', 'Tugas berhasil dikumpulkan!');
    }
}
