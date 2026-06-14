<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $latestCourses = \App\Models\Course::where('status', 'published')
        ->latest('published_at')
        ->take(3)
        ->get();
    $pageContent = app(\App\Services\PageContentService::class)->getPage('home');
    return view('pages.home', compact('latestCourses', 'pageContent'));
})->name('home');

Route::get('/courses', [\App\Http\Controllers\PublicCourseController::class, 'index'])->name('courses');
Route::get('/courses/{course:slug}', [\App\Http\Controllers\PublicCourseController::class, 'show'])->name('courses.show');
Route::get('/courses/{course:slug}/lessons/{lesson:slug}', [\App\Http\Controllers\PublicCourseController::class, 'lesson'])->name('courses.lesson');
Route::post('/assignments/{assignment}/submit', [\App\Http\Controllers\SubmissionController::class, 'store'])->name('submissions.store');
Route::post('/courses/{course}/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');

Route::get('/about', function () {
    $pageContent = app(\App\Services\PageContentService::class)->getPage('about');
    return view('pages.about', compact('pageContent'));
})->name('about');

Route::get('/contact', function () {
    $pageContent = app(\App\Services\PageContentService::class)->getPage('contact');
    return view('pages.contact', compact('pageContent'));
})->name('contact');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');

    Route::resource('courses', \App\Http\Controllers\Admin\CourseController::class);
    Route::resource('courses.lessons', \App\Http\Controllers\Admin\LessonController::class)->shallow();
    Route::resource('lessons.blocks', \App\Http\Controllers\Admin\ContentBlockController::class)->shallow();
    Route::resource('courses.assignments', \App\Http\Controllers\Admin\AssignmentController::class)->shallow();
    Route::resource('assignments.submissions', \App\Http\Controllers\Admin\SubmissionController::class)->shallow();

    Route::get('/pages', [\App\Http\Controllers\Admin\PageContentController::class, 'index'])->name('pages.index');
    Route::get('/pages/{pageKey}/edit', [\App\Http\Controllers\Admin\PageContentController::class, 'edit'])->name('pages.edit');
    Route::put('/pages/{pageKey}', [\App\Http\Controllers\Admin\PageContentController::class, 'update'])->name('pages.update');
});

require __DIR__.'/auth.php';
