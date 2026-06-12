<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use App\Services\PageContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageContentController extends Controller
{
    /**
     * Display a listing of managed pages.
     */
    public function index(): View
    {
        $pages = [
            'home' => 'Halaman Utama (Home)',
            'about' => 'Halaman Tentang Kami (About)',
            'contact' => 'Halaman Hubungi Kami (Contact)',
            'courses' => 'Halaman Katalog Kursus (Courses)',
        ];

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for editing the specified page content.
     */
    public function edit(string $pageKey): View
    {
        $validPages = ['home', 'about', 'contact', 'courses'];
        if (!in_array($pageKey, $validPages)) {
            abort(404);
        }

        $content = app(PageContentService::class)->getPage($pageKey);

        return view("admin.pages.edit-{$pageKey}", compact('pageKey', 'content'));
    }

    /**
     * Update the specified page content in storage.
     */
    public function update(Request $request, string $pageKey): RedirectResponse
    {
        $validPages = ['home', 'about', 'contact', 'courses'];
        if (!in_array($pageKey, $validPages)) {
            abort(404);
        }

        $sections = $request->input('sections', []);

        // Custom preprocessing for Contact Info Cards line textareas
        if ($pageKey === 'contact' && isset($sections['info']['cards'])) {
            foreach ($sections['info']['cards'] as $idx => $card) {
                if (isset($card['lines_text'])) {
                    $lines = array_filter(array_map('trim', explode("\n", $card['lines_text'])));
                    $sections['info']['cards'][$idx]['lines'] = array_values($lines);
                    unset($sections['info']['cards'][$idx]['lines_text']);
                }
            }
        }

        // Custom preprocessing for Courses Filter chips
        if ($pageKey === 'courses' && isset($sections['filters']['chips_text'])) {
            $chips = array_filter(array_map('trim', explode(',', $sections['filters']['chips_text'])));
            $sections['filters']['chips'] = array_values($chips);
            unset($sections['filters']['chips_text']);
        }

        // Handle Image Uploads dynamically
        if ($pageKey === 'home') {
            if ($request->hasFile('hero_image')) {
                $request->validate(['hero_image' => 'image|mimes:jpeg,png,jpg,webp|max:2048']);
                $path = $request->file('hero_image')->store('page-content/home', 'public');
                $sections['hero']['image_url'] = $path;
            }
            if ($request->hasFile('founder_photo')) {
                $request->validate(['founder_photo' => 'image|mimes:jpeg,png,jpg,webp|max:2048']);
                $path = $request->file('founder_photo')->store('page-content/home', 'public');
                $sections['founder']['photo_url'] = $path;
            }
        } elseif ($pageKey === 'about') {
            if ($request->hasFile('vision_image')) {
                $request->validate(['vision_image' => 'image|mimes:jpeg,png,jpg,webp|max:2048']);
                $path = $request->file('vision_image')->store('page-content/about', 'public');
                $sections['vision']['image_url'] = $path;
            }
        } elseif ($pageKey === 'courses') {
            if ($request->hasFile('courses_hero_image')) {
                $request->validate(['courses_hero_image' => 'image|mimes:jpeg,png,jpg,webp|max:2048']);
                $path = $request->file('courses_hero_image')->store('page-content/courses', 'public');
                $sections['hero']['image_url'] = $path;
            }
        }

        // Validate structure depending on pageKey
        $rules = [];
        if ($pageKey === 'home') {
            $rules = [
                'sections.hero.badge' => 'required|string|max:255',
                'sections.hero.title_before_highlight' => 'nullable|string|max:255',
                'sections.hero.title_highlight' => 'required|string|max:255',
                'sections.hero.title_after_highlight' => 'nullable|string|max:255',
                'sections.hero.description' => 'required|string',
                'sections.hero.primary_button_label' => 'required|string|max:100',
                'sections.hero.primary_button_url' => 'required|string|max:255',
                'sections.hero.secondary_button_label' => 'required|string|max:100',
                'sections.hero.secondary_button_url' => 'required|string|max:255',
                'sections.hero.stat_number' => 'required|string|max:50',
                'sections.hero.stat_label' => 'required|string|max:100',
                
                'sections.founder.role' => 'required|string|max:255',
                'sections.founder.name' => 'required|string|max:255',
                'sections.founder.quote' => 'required|string',
                'sections.founder.bio' => 'required|string',
                'sections.founder.social_links' => 'required|array',
                'sections.founder.social_links.*.label' => 'required|string|max:100',
                'sections.founder.social_links.*.icon' => 'required|string|max:100',
                'sections.founder.social_links.*.url' => 'required|string|max:255',
                
                'sections.features.title' => 'required|string|max:255',
                'sections.features.description' => 'required|string',
                'sections.features.items' => 'required|array|size:4',
                'sections.features.items.*.icon' => 'required|string|max:100',
                'sections.features.items.*.title' => 'required|string|max:255',
                'sections.features.items.*.description' => 'required|string',
                'sections.features.items.*.color_variant' => 'required|string|max:100',
                
                'sections.course_preview.title' => 'required|string|max:255',
                'sections.course_preview.description' => 'required|string',
                'sections.course_preview.link_label' => 'required|string|max:100',
                'sections.course_preview.link_url' => 'required|string|max:255',
                'sections.course_preview.empty_state_text' => 'required|string|max:255',
            ];
        } elseif ($pageKey === 'about') {
            $rules = [
                'sections.hero.page_title' => 'required|string|max:255',
                'sections.hero.badge' => 'required|string|max:255',
                'sections.hero.title_before_highlight' => 'nullable|string|max:255',
                'sections.hero.title_highlight' => 'required|string|max:255',
                'sections.hero.description' => 'required|string',
                
                'sections.vision.title' => 'required|string|max:255',
                'sections.vision.paragraphs' => 'required|array|min:1',
                'sections.vision.paragraphs.*' => 'required|string',
                'sections.vision.image_alt' => 'required|string|max:255',
            ];
        } elseif ($pageKey === 'contact') {
            $rules = [
                'sections.hero.page_title' => 'required|string|max:255',
                'sections.hero.title_before_highlight' => 'nullable|string|max:255',
                'sections.hero.title_highlight' => 'required|string|max:255',
                'sections.hero.description' => 'required|string',
                
                'sections.info.cards' => 'required|array|size:3',
                'sections.info.cards.*.icon' => 'required|string|max:100',
                'sections.info.cards.*.title' => 'required|string|max:255',
                'sections.info.cards.*.lines' => 'required|array',
                'sections.info.cards.*.lines.*' => 'required|string',
                'sections.info.cards.*.link_label' => 'nullable|string|max:255',
                'sections.info.cards.*.link_url' => 'nullable|string|max:255',
                
                'sections.form.title' => 'required|string|max:255',
                'sections.form.button_label' => 'required|string|max:255',
            ];
        } elseif ($pageKey === 'courses') {
            $rules = [
                'sections.hero.page_title' => 'required|string|max:255',
                'sections.hero.title' => 'required|string|max:255',
                'sections.hero.description' => 'required|string',
                'sections.hero.primary_button_label' => 'required|string|max:100',
                'sections.hero.primary_button_url' => 'required|string|max:255',
                'sections.hero.secondary_button_label' => 'required|string|max:100',
                'sections.hero.secondary_button_url' => 'required|string|max:255',
                'sections.hero.image_alt' => 'required|string|max:255',
                
                'sections.filters.search_placeholder' => 'required|string|max:255',
                'sections.filters.chips' => 'required|array',
                'sections.filters.chips.*' => 'required|string|max:255',
                
                'sections.grid.empty_state_title' => 'required|string|max:255',
                'sections.grid.load_more_label' => 'required|string|max:255',
                'sections.grid.detail_label' => 'required|string|max:255',
                'sections.grid.default_level_label' => 'required|string|max:255',
                'sections.grid.default_category_label' => 'required|string|max:255',
                
                'sections.newsletter.title' => 'required|string|max:255',
                'sections.newsletter.description' => 'required|string',
                'sections.newsletter.email_placeholder' => 'required|string|max:255',
                'sections.newsletter.button_label' => 'required|string|max:255',
            ];
        }

        // Apply "sometimes" dynamically to all sub-fields under sections for robust partial updates
        foreach ($rules as $key => $rule) {
            if (str_starts_with($key, 'sections.')) {
                if (is_string($rule)) {
                    $rules[$key] = 'sometimes|' . $rule;
                } elseif (is_array($rule)) {
                    array_unshift($rule, 'sometimes');
                    $rules[$key] = $rule;
                }
            }
        }

        $request->validate($rules);

        // Fetch existing content to merge and avoid overwriting non-form data (like current image URLs)
        $service = app(PageContentService::class);
        $currentContent = $service->getPage($pageKey);

        foreach ($sections as $sectionKey => $sectionData) {
            $oldContent = $currentContent[$sectionKey] ?? [];
            $newContent = $service->mergeRecursive($oldContent, $sectionData);

            PageContent::updateOrCreate(
                [
                    'page_key' => $pageKey,
                    'section_key' => $sectionKey,
                ],
                [
                    'content' => $newContent,
                    'is_active' => true,
                    'updated_by' => auth()->id(),
                ]
            );
        }

        return redirect()->route('admin.pages.index')
            ->with('success', 'Konten halaman berhasil diperbarui.');
    }
}
