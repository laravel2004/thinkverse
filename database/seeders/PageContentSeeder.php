<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = config('public_pages', []);

        foreach ($pages as $pageKey => $sections) {
            foreach ($sections as $sectionKey => $content) {
                \App\Models\PageContent::updateOrCreate(
                    [
                        'page_key' => $pageKey,
                        'section_key' => $sectionKey,
                    ],
                    [
                        'content' => $content,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
