<?php

use App\Models\PageContent;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        PageContent::query()
            ->where('page_key', 'home')
            ->where('section_key', 'hero')
            ->update([
                'content->primary_button_url' => '/courses#list-kursus',
            ]);

        PageContent::query()
            ->where('page_key', 'courses')
            ->where('section_key', 'hero')
            ->update([
                'content->primary_button_url' => '/courses#list-kursus',
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        PageContent::query()
            ->where('page_key', 'home')
            ->where('section_key', 'hero')
            ->update([
                'content->primary_button_url' => '#',
            ]);

        PageContent::query()
            ->where('page_key', 'courses')
            ->where('section_key', 'hero')
            ->update([
                'content->primary_button_url' => '#',
            ]);
    }
};
