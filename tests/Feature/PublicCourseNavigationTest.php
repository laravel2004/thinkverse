<?php

namespace Tests\Feature;

use App\Http\Controllers\PublicCourseController;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicCourseNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_parent_chapter_with_children_is_clickable_and_shows_assignment(): void
    {
        $course = Course::create([
            'title' => 'Independent Financial Freedom',
            'slug' => 'independent-financial-freedom',
            'description' => 'Course description',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $chapter = Lesson::create([
            'course_id' => $course->id,
            'title' => 'Apa itu Independent',
            'slug' => 'apa-itu-independent',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        $subLesson = Lesson::create([
            'course_id' => $course->id,
            'parent_id' => $chapter->id,
            'title' => 'Mindset Independent',
            'slug' => 'mindset-independent',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        Assignment::create([
            'course_id' => $course->id,
            'lesson_id' => $chapter->id,
            'title' => 'Tugas Bab 1',
            'instruction' => 'Upload refleksi awal dalam format PDF.',
            'is_active' => true,
        ]);

        $response = $this->get(route('courses.lesson', [$course, $subLesson]));

        $response->assertOk();
        $response->assertSee('Bab 1: Apa itu Independent');
        $response->assertSee(route('courses.lesson', [$course, $chapter]), false);
        $response->assertSee('Tugas');

        $parentResponse = $this->get(route('courses.lesson', [$course, $chapter]));

        $parentResponse->assertOk();
        $parentResponse->assertSee('Tugas & Evaluasi', false);
        $parentResponse->assertSee('Tugas Bab 1');
    }

    public function test_course_detail_links_parent_chapter_even_when_it_has_children(): void
    {
        $course = Course::create([
            'title' => 'Independent Financial Freedom',
            'slug' => 'independent-financial-freedom',
            'description' => 'Course description',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $chapter = Lesson::create([
            'course_id' => $course->id,
            'title' => 'Apa itu Independent',
            'slug' => 'apa-itu-independent',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        Lesson::create([
            'course_id' => $course->id,
            'parent_id' => $chapter->id,
            'title' => 'Mindset Independent',
            'slug' => 'mindset-independent',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        Assignment::create([
            'course_id' => $course->id,
            'lesson_id' => $chapter->id,
            'title' => 'Tugas Bab 1',
            'instruction' => 'Upload refleksi awal dalam format PDF.',
            'is_active' => true,
        ]);

        $response = $this->get(route('courses.show', $course));

        $response->assertOk();
        $response->assertSee('Bab 1: Apa itu Independent');
        $response->assertSee(route('courses.lesson', [$course, $chapter]), false);
        $response->assertSee('Tugas');
    }

    public function test_lesson_page_allows_string_foreign_key_values_from_database_driver(): void
    {
        $course = Course::create([
            'title' => 'Testing',
            'slug' => 'testing',
            'description' => 'Course description',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $lesson = Lesson::create([
            'course_id' => $course->id,
            'title' => 'Dsds',
            'slug' => 'dsds-6a2cc7338396a',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        $lesson->setRawAttributes([
            ...$lesson->getAttributes(),
            'course_id' => (string) $course->id,
        ], true);

        $view = (new PublicCourseController())->lesson($course, $lesson);

        $this->assertSame('pages.courses.lesson', $view->name());
    }
}
