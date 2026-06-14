<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\PageContent;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicGuestInteractionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_create_comment_with_name(): void
    {
        $course = Course::create([
            'title' => 'Public Course',
            'slug' => 'public-course',
            'description' => 'Course description',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->post(route('comments.store', $course), [
            'guest_name' => 'Budi',
            'body' => 'Materinya mudah dipahami.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('comments', [
            'course_id' => $course->id,
            'user_id' => null,
            'guest_name' => 'Budi',
            'body' => 'Materinya mudah dipahami.',
            'status' => 'visible',
        ]);
    }

    public function test_guest_can_reply_to_comment_with_name(): void
    {
        $course = Course::create([
            'title' => 'Public Course',
            'slug' => 'public-course',
            'description' => 'Course description',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $parent = Comment::create([
            'course_id' => $course->id,
            'guest_name' => 'Budi',
            'body' => 'Pertanyaan pertama.',
            'status' => 'visible',
        ]);

        $this->post(route('comments.store', $course), [
            'guest_name' => 'Sari',
            'body' => 'Ini jawabannya.',
            'parent_id' => $parent->id,
        ])->assertRedirect();

        $this->assertDatabaseHas('comments', [
            'course_id' => $course->id,
            'parent_id' => $parent->id,
            'user_id' => null,
            'guest_name' => 'Sari',
            'body' => 'Ini jawabannya.',
        ]);
    }

    public function test_guest_can_submit_assignment_with_name_and_pdf(): void
    {
        Storage::fake('public');

        $course = Course::create([
            'title' => 'Public Course',
            'slug' => 'public-course',
            'description' => 'Course description',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $assignment = Assignment::create([
            'course_id' => $course->id,
            'title' => 'Tugas PDF',
            'instruction' => 'Upload PDF.',
            'is_active' => true,
        ]);

        $this->post(route('submissions.store', $assignment), [
            'student_name' => 'Budi',
            'submission_file' => UploadedFile::fake()->create('tugas.pdf', 32, 'application/pdf'),
        ])->assertRedirect();

        $submission = Submission::first();

        $this->assertNotNull($submission);
        $this->assertSame('Budi', $submission->student_name);
        $this->assertNull($submission->user_id);
        $this->assertSame('pending', $submission->status);
        Storage::disk('public')->assertExists($submission->file_path);
    }

    public function test_lesson_page_shows_guest_forms_without_login_links(): void
    {
        $course = Course::create([
            'title' => 'Public Course',
            'slug' => 'public-course',
            'description' => 'Course description',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $lesson = Lesson::create([
            'course_id' => $course->id,
            'title' => 'Lesson 1',
            'slug' => 'lesson-1',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        Assignment::create([
            'course_id' => $course->id,
            'lesson_id' => $lesson->id,
            'title' => 'Tugas PDF',
            'instruction' => 'Upload PDF.',
            'is_active' => true,
        ]);

        $this->get(route('courses.lesson', [$course, $lesson]))
            ->assertOk()
            ->assertSee('Nama Pengumpul')
            ->assertSee('Nama Anda')
            ->assertDontSee('Login Sekarang')
            ->assertDontSee('Silakan')
            ->assertDontSee('/login', false);
    }

    public function test_admin_submission_list_renders_guest_submission_without_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $course = Course::create([
            'title' => 'Public Course',
            'slug' => 'public-course',
            'description' => 'Course description',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $assignment = Assignment::create([
            'course_id' => $course->id,
            'title' => 'Tugas PDF',
            'instruction' => 'Upload PDF.',
            'is_active' => true,
        ]);

        Submission::create([
            'assignment_id' => $assignment->id,
            'student_name' => 'Budi',
            'file_path' => 'submissions/tugas.pdf',
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        $this->actingAs($admin)
            ->get(route('admin.assignments.submissions.index', $assignment))
            ->assertOk()
            ->assertSee('Budi')
            ->assertSee('Menunggu Reviu');
    }

    public function test_home_and_courses_cta_links_scroll_to_course_list_section(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('/courses#list-kursus', false);

        $this->get(route('courses'))
            ->assertOk()
            ->assertSee('/courses#list-kursus', false)
            ->assertSee('/about', false)
            ->assertSee('id="list-kursus"', false);
    }

    public function test_courses_page_can_filter_by_category(): void
    {
        Course::create([
            'title' => 'Design Basics',
            'slug' => 'design-basics',
            'category' => 'Design',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Course::create([
            'title' => 'Programming Basics',
            'slug' => 'programming-basics',
            'category' => 'Programming',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->get(route('courses', ['category' => 'Design']))
            ->assertOk()
            ->assertSee('Design Basics')
            ->assertDontSee('Programming Basics')
            ->assertSee('active-filter', false);
    }

    public function test_courses_page_can_search_courses(): void
    {
        Course::create([
            'title' => 'Laravel for Beginners',
            'slug' => 'laravel-for-beginners',
            'description' => 'Learn backend development with Laravel.',
            'category' => 'Programming',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Course::create([
            'title' => 'Design Thinking',
            'slug' => 'design-thinking',
            'description' => 'Learn product design fundamentals.',
            'category' => 'Design',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->get(route('courses', ['q' => 'laravel']))
            ->assertOk()
            ->assertSee('Laravel for Beginners')
            ->assertDontSee('Design Thinking')
            ->assertSee('Cari', false);
    }

    public function test_courses_load_more_endpoint_returns_next_page_html(): void
    {
        foreach (range(1, 13) as $index) {
            Course::create([
                'title' => "Course {$index}",
                'slug' => "course-{$index}",
                'description' => 'Course description',
                'category' => 'Programming',
                'status' => 'published',
                'published_at' => now(),
            ]);
        }

        $response = $this->get(route('courses', ['page' => 2, 'append' => 1]));

        $response->assertOk();
        $response->assertJsonStructure(['html', 'next_page_url', 'has_more']);
        $response->assertJsonPath('has_more', false);
        $this->assertStringContainsString('Course 13', $response->json('html'));
    }

    public function test_contact_form_uses_support_email_from_database(): void
    {
        PageContent::updateOrCreate(
            [
                'page_key' => 'contact',
                'section_key' => 'info',
            ],
            [
                'content' => [
                    'cards' => [
                        [
                            'icon' => 'mail',
                            'title' => 'Email Dukungan',
                            'lines' => ['Untuk pertanyaan umum:'],
                            'link_label' => 'support@thinkverse.test',
                            'link_url' => 'mailto:support@thinkverse.test',
                        ],
                    ],
                ],
                'is_active' => true,
            ]
        );

        $this->get(route('contact'))
            ->assertOk()
            ->assertSee('data-support-email="support@thinkverse.test"', false)
            ->assertSee('mailto:support@thinkverse.test', false);
    }
}
