<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class PublicCourseController extends Controller
{
    private function loadPublishedLessonNavigation(Course $course): void
    {
        $course->load(['lessons' => function($q) {
            $q->where('status', 'published')
                ->with(['children' => function ($q) {
                    $q->where('status', 'published')
                        ->withCount(['assignments as active_assignments_count' => function ($q) {
                            $q->where('is_active', true);
                        }])
                        ->orderBy('sort_order');
                }])
                ->withCount(['assignments as active_assignments_count' => function ($q) {
                    $q->where('is_active', true);
                }])
                ->orderBy('sort_order');
        }]);
    }

    public function index(Request $request)
    {
        $selectedCategory = trim((string) $request->query('category', ''));
        $searchQuery = trim((string) $request->query('q', ''));

        $coursesQuery = Course::where('status', 'published')
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc');

        if ($selectedCategory !== '' && strtolower($selectedCategory) !== 'semua') {
            $normalizedCategory = mb_strtolower($selectedCategory);

            $coursesQuery->whereRaw('LOWER(TRIM(category)) = ?', [$normalizedCategory]);
        }

        if ($searchQuery !== '') {
            $normalizedSearch = mb_strtolower($searchQuery);

            $coursesQuery->where(function ($query) use ($normalizedSearch) {
                $query->whereRaw('LOWER(title) LIKE ?', ['%' . $normalizedSearch . '%'])
                    ->orWhereRaw('LOWER(COALESCE(excerpt, "")) LIKE ?', ['%' . $normalizedSearch . '%'])
                    ->orWhereRaw('LOWER(COALESCE(description, "")) LIKE ?', ['%' . $normalizedSearch . '%'])
                    ->orWhereRaw('LOWER(COALESCE(category, "")) LIKE ?', ['%' . $normalizedSearch . '%']);
            });
        }

        $courses = $coursesQuery->paginate(12)->withQueryString();
        $pageContent = app(\App\Services\PageContentService::class)->getPage('courses');

        // Fetch unique categories from database for published courses
        $dbCategories = Course::where('status', 'published')
            ->whereNotNull('category')
            ->where('category', '<>', '')
            ->pluck('category')
            ->map(fn($cat) => trim($cat))
            ->unique(fn($cat) => strtolower($cat))
            ->values()
            ->toArray();

        // Inject the dynamic categories into filter chips, keeping "Semua" as the first chip
        if (isset($pageContent['filters'])) {
            $pageContent['filters']['chips'] = array_merge(['Semua'], $dbCategories);
        }

        if ($request->boolean('append')) {
            $cardsHtml = collect($courses->items())->map(function (Course $course) use ($pageContent) {
                return view('pages.courses.partials.course-card', compact('course', 'pageContent'))->render();
            })->implode('');

            return response()->json([
                'html' => $cardsHtml,
                'next_page_url' => $courses->nextPageUrl(),
                'has_more' => $courses->hasMorePages(),
            ]);
        }

        return view('pages.courses', compact('courses', 'pageContent', 'selectedCategory', 'searchQuery'));
    }

    public function show(Course $course)
    {
        if ($course->status !== 'published') {
            abort(404);
        }

        $this->loadPublishedLessonNavigation($course);

        $firstLesson = $course->lessons->whereNull('parent_id')->first();

        return view('pages.courses.show', compact('course', 'firstLesson'));
    }

    public function lesson(Course $course, Lesson $lesson)
    {
        if ($course->status !== 'published' || $lesson->status !== 'published' || (int) $lesson->course_id !== (int) $course->getKey()) {
            abort(404);
        }

        $lesson->load(['contentBlocks' => function($q) {
            $q->orderBy('sort_order');
        }]);

        $this->loadPublishedLessonNavigation($course);

        // Load assignments if any
        $assignments = $lesson->assignments()->where('is_active', true)->get();
        if ($assignments->isEmpty()) {
            $assignments = $course->assignments()->whereNull('lesson_id')->where('is_active', true)->get();
        }

        $comments = $course->comments()->whereNull('parent_id')->with('user', 'replies.user')->orderBy('created_at', 'desc')->get();

        return view('pages.courses.lesson', compact('course', 'lesson', 'assignments', 'comments'));
    }
}
