<?php

namespace Tests\Feature\Admin;

use App\Models\PageContent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageContentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed default content so fallbacks are available
        $this->seed(\Database\Seeders\PageContentSeeder::class);
    }

    public function test_guest_cannot_access_page_management(): void
    {
        $response = $this->get(route('admin.pages.index'));
        $response->assertRedirect('/login');

        $response = $this->get(route('admin.pages.edit', 'home'));
        $response->assertRedirect('/login');

        $response = $this->put(route('admin.pages.update', 'home'), []);
        $response->assertRedirect('/login');
    }

    public function test_non_admin_cannot_access_page_management(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get(route('admin.pages.index'));
        $response->assertRedirect('/');
        $response->assertSessionHas('error');

        $response = $this->actingAs($user)->get(route('admin.pages.edit', 'home'));
        $response->assertRedirect('/');

        $response = $this->actingAs($user)->put(route('admin.pages.update', 'home'), []);
        $response->assertRedirect('/');
    }

    public function test_admin_can_access_page_management_index(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.pages.index'));
        $response->assertStatus(200);
        $response->assertSee('Kelola Konten Halaman');
        $response->assertSee('home');
        $response->assertSee('about');
        $response->assertSee('contact');
        $response->assertSee('courses');
    }

    public function test_admin_can_edit_page_content_form(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.pages.edit', 'home'));
        $response->assertStatus(200);
        $response->assertSee('Platform Pembelajaran Terstruktur');
    }

    public function test_admin_can_update_page_content(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Fetch fallback config as base payload
        $content = config('public_pages.home');
        $content['hero']['title_highlight'] = 'NewThinkVerse';

        $response = $this->actingAs($admin)->put(route('admin.pages.update', 'home'), [
            'sections' => $content
        ]);

        $response->assertRedirect(route('admin.pages.index'));
        $response->assertSessionHas('success');

        // Check if database updated
        $this->assertDatabaseHas('page_contents', [
            'page_key' => 'home',
            'section_key' => 'hero',
        ]);

        // Check if public view shows the updated title
        $responsePublic = $this->get(route('home'));
        $responsePublic->assertStatus(200);
        $responsePublic->assertSee('NewThinkVerse');
    }

    public function test_fallback_works_when_database_empty(): void
    {
        // Truncate page_contents
        PageContent::truncate();

        // Check public pages load fine
        $this->get(route('home'))->assertStatus(200)->assertSee('ThinkVerse');
        $this->get(route('about'))->assertStatus(200)->assertSee('Tentang Kami');
        $this->get(route('contact'))->assertStatus(200)->assertSee('Hubungi');
        $this->get(route('courses'))->assertStatus(200)->assertSee('Eksplorasi');
    }

    public function test_courses_page_displays_unique_categories_from_database(): void
    {
        // Create courses with mixed-case category names
        \App\Models\Course::create([
            'title' => 'Course 1',
            'slug' => 'course-1',
            'category' => 'programmer',
            'status' => 'published',
        ]);
        \App\Models\Course::create([
            'title' => 'Course 2',
            'slug' => 'course-2',
            'category' => 'Programmer',
            'status' => 'published',
        ]);
        \App\Models\Course::create([
            'title' => 'Course 3',
            'slug' => 'course-3',
            'category' => 'design',
            'status' => 'published',
        ]);

        $response = $this->get(route('courses'));
        $response->assertStatus(200);

        // Verify categories are rendered
        $response->assertSee('programmer');
        $response->assertSee('design');

        // Verify that the duplicate category has been merged and does not show up as a separate duplicate
        $response->assertViewHas('pageContent');
        $chips = $response->viewData('pageContent')['filters']['chips'];
        $this->assertContains('programmer', $chips);
        $this->assertNotContains('Programmer', $chips);
    }
}
