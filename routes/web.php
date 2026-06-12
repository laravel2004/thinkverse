<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $latestCourses = \App\Models\Course::where('status', 'published')
        ->latest('published_at')
        ->take(3)
        ->get();
    return view('pages.home', compact('latestCourses'));
})->name('home');

Route::get('/courses', [\App\Http\Controllers\PublicCourseController::class, 'index'])->name('courses');
Route::get('/courses/{course:slug}', [\App\Http\Controllers\PublicCourseController::class, 'show'])->name('courses.show');
Route::get('/courses/{course:slug}/lessons/{lesson:slug}', [\App\Http\Controllers\PublicCourseController::class, 'lesson'])->name('courses.lesson');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $stats = [
            'students' => \App\Models\User::where('role', 'user')->count(),
            'courses' => \App\Models\Course::count(),
            'submissions' => \App\Models\Submission::count(),
            'lessons' => \App\Models\Lesson::count(),
        ];
        return view('admin.dashboard', compact('stats'));
    })->name('dashboard');

    Route::resource('courses', \App\Http\Controllers\Admin\CourseController::class);
    Route::resource('courses.lessons', \App\Http\Controllers\Admin\LessonController::class)->shallow();
    Route::resource('lessons.blocks', \App\Http\Controllers\Admin\ContentBlockController::class)->shallow();
    Route::resource('courses.assignments', \App\Http\Controllers\Admin\AssignmentController::class)->shallow();
    Route::resource('assignments.submissions', \App\Http\Controllers\Admin\SubmissionController::class)->shallow();
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::post('/assignments/{assignment}/submit', [\App\Http\Controllers\SubmissionController::class, 'store'])->name('submissions.store');
    Route::post('/courses/{course}/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
});

require __DIR__.'/auth.php';
