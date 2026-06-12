<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Submission;
use App\Models\Lesson;
use App\Models\Comment;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'students' => User::where('role', 'user')->count(),
            'courses' => Course::count(),
            'submissions' => Submission::count(),
            'lessons' => Lesson::count(),
        ];

        $registeredUsers = User::query()
            ->where('role', 'user')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($user) {
                return [
                    'type' => 'user_registered',
                    'icon' => 'person_add',
                    'badge_color' => 'bg-primary/10 text-primary',
                    'label' => 'Pendaftaran',
                    'title' => 'User baru mendaftar',
                    'description' => "{$user->name} bergabung sebagai user baru.",
                    'time' => $user->created_at,
                    'url' => route('admin.users.index'),
                ];
            });

        $submittedAssignments = Submission::query()
            ->with(['user', 'assignment'])
            ->latest('submitted_at')
            ->take(10)
            ->get()
            ->map(function ($submission) {
                return [
                    'type' => 'assignment_submitted',
                    'icon' => 'assignment_turned_in',
                    'badge_color' => 'bg-blue-500/10 text-blue-600',
                    'label' => 'Tugas',
                    'title' => 'Tugas dikumpulkan',
                    'description' => "{$submission->user?->name} mengumpulkan tugas " . ($submission->assignment?->title ?? 'terhapus') . ".",
                    'time' => $submission->submitted_at ?? $submission->created_at,
                    'url' => null,
                ];
            });

        $comments = Comment::query()
            ->with(['user', 'course'])
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($comment) {
                return [
                    'type' => 'comment_created',
                    'icon' => 'forum',
                    'badge_color' => 'bg-emerald-500/10 text-emerald-600',
                    'label' => 'Komentar',
                    'title' => 'Komentar baru',
                    'description' => "{$comment->user?->name} menulis komentar di kursus " . ($comment->course?->title ?? 'terhapus') . ".",
                    'time' => $comment->created_at,
                    'url' => $comment->course ? route('courses.show', $comment->course) : null,
                ];
            });

        $activities = collect()
            ->merge($registeredUsers)
            ->merge($submittedAssignments)
            ->merge($comments)
            ->sortByDesc('time')
            ->take(10)
            ->values();

        return view('admin.dashboard', compact('stats', 'activities'));
    }
}
