@extends('layouts.admin')

@section('title', 'Edit Halaman Katalog Kursus')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 mb-2 text-sm font-medium text-on-surface-variant">
        <a href="{{ route('admin.pages.index') }}" class="hover:text-primary transition-colors">Konten Halaman</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span class="text-on-surface">Courses</span>
    </div>
    <h1 class="font-display-lg text-3xl font-extrabold text-on-surface">Edit Halaman Katalog Kursus (Courses)</h1>
    <p class="text-on-surface-variant font-medium mt-1">Ubah konten hero, filter, teks kartu, dan newsletter untuk katalog kursus.</p>
</div>

<form action="{{ route('admin.pages.update', 'courses') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')

    <!-- HERO SECTION -->
    <div class="bg-white rounded-[2rem] border border-primary/5 shadow-sm p-6 lg:p-8 space-y-6">
        <h2 class="text-xl font-bold text-primary flex items-center gap-2 pb-4 border-b border-primary/5">
            <span class="material-symbols-outlined">menu_book</span>
            Section 1: Hero Pemasaran
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Meta Title Halaman</label>
                <input type="text" name="sections[hero][page_title]" value="{{ old('sections.hero.page_title', data_get($content, 'hero.page_title')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Judul Hero</label>
                <input type="text" name="sections[hero][title]" value="{{ old('sections.hero.title', data_get($content, 'hero.title')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Alt Text Gambar</label>
                <input type="text" name="sections[hero][image_alt]" value="{{ old('sections.hero.image_alt', data_get($content, 'hero.image_alt')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-on-surface mb-2">Deskripsi Hero</label>
            <textarea name="sections[hero][description]" rows="3" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface resize-y" required>{{ old('sections.hero.description', data_get($content, 'hero.description')) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-4 bg-surface/50 rounded-2xl border border-primary/5 space-y-4">
                <h3 class="font-bold text-sm text-on-surface">Tombol Utama (Primary)</h3>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Label Tombol</label>
                    <input type="text" name="sections[hero][primary_button_label]" value="{{ old('sections.hero.primary_button_label', data_get($content, 'hero.primary_button_label')) }}" class="w-full px-4 py-2.5 bg-white border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-on-surface text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Tautan URL</label>
                    <input type="text" name="sections[hero][primary_button_url]" value="{{ old('sections.hero.primary_button_url', data_get($content, 'hero.primary_button_url')) }}" class="w-full px-4 py-2.5 bg-white border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-on-surface text-sm" required>
                </div>
            </div>

            <div class="p-4 bg-surface/50 rounded-2xl border border-primary/5 space-y-4">
                <h3 class="font-bold text-sm text-on-surface">Tombol Kedua (Secondary)</h3>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Label Tombol</label>
                    <input type="text" name="sections[hero][secondary_button_label]" value="{{ old('sections.hero.secondary_button_label', data_get($content, 'hero.secondary_button_label')) }}" class="w-full px-4 py-2.5 bg-white border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-on-surface text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Tautan URL</label>
                    <input type="text" name="sections[hero][secondary_button_url]" value="{{ old('sections.hero.secondary_button_url', data_get($content, 'hero.secondary_button_url')) }}" class="w-full px-4 py-2.5 bg-white border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-on-surface text-sm" required>
                </div>
            </div>
        </div>

        <div class="p-4 bg-surface/50 rounded-2xl border border-primary/5">
            <label class="block text-sm font-bold text-on-surface mb-2">Gambar Hero Utama</label>
            @php
                $heroImage = data_get($content, 'hero.image_url');
                $isImageExternal = Str::startsWith($heroImage, ['http://', 'https://']);
                $resolvedHeroImage = $isImageExternal ? $heroImage : Storage::url($heroImage);
            @endphp
            @if($heroImage)
                <div class="mb-4">
                    <img src="{{ $resolvedHeroImage }}" alt="Preview" class="w-48 h-48 object-cover rounded-xl border border-primary/10">
                </div>
            @endif
            <div class="relative group cursor-pointer w-48">
                <input type="file" name="courses_hero_image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                <div class="w-full h-24 border-2 border-dashed border-primary/20 bg-white rounded-xl flex flex-col items-center justify-center text-on-surface-variant group-hover:border-primary/50 group-hover:bg-primary/5 transition-all">
                    <span class="material-symbols-outlined text-2xl mb-1">add_photo_alternate</span>
                    <span class="text-xs font-medium">Klik Ganti Gambar</span>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTERS SECTION -->
    <div class="bg-white rounded-[2rem] border border-primary/5 shadow-sm p-6 lg:p-8 space-y-6">
        <h2 class="text-xl font-bold text-primary flex items-center gap-2 pb-4 border-b border-primary/5">
            <span class="material-symbols-outlined">filter_list</span>
            Section 2: Filter Pencarian
        </h2>

        <div>
            <label class="block text-sm font-bold text-on-surface mb-2">Placeholder Input Pencarian</label>
            <input type="text" name="sections[filters][search_placeholder]" value="{{ old('sections.filters.search_placeholder', data_get($content, 'filters.search_placeholder')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
        </div>

        <div>
            <label class="block text-sm font-bold text-on-surface mb-2">Filter Chips Kategori (Pisahkan dengan koma `,` )</label>
            <input type="text" name="sections[filters][chips_text]" value="{{ old('sections.filters.chips_text', implode(', ', data_get($content, 'filters.chips', []))) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" placeholder="Semua, Coding, Desain" required>
            <p class="mt-1 text-xs text-on-surface-variant">Contoh: Semua, Matematika, IPA Terpadu, Coding</p>
        </div>
    </div>

    <!-- GRID SETTINGS SECTION -->
    <div class="bg-white rounded-[2rem] border border-primary/5 shadow-sm p-6 lg:p-8 space-y-6">
        <h2 class="text-xl font-bold text-primary flex items-center gap-2 pb-4 border-b border-primary/5">
            <span class="material-symbols-outlined">grid_view</span>
            Section 3: Pengaturan Grid Kartu
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Judul State Kosong (Empty State)</label>
                <input type="text" name="sections[grid][empty_state_title]" value="{{ old('sections.grid.empty_state_title', data_get($content, 'grid.empty_state_title')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Label Tombol Load More</label>
                <input type="text" name="sections[grid][load_more_label]" value="{{ old('sections.grid.load_more_label', data_get($content, 'grid.load_more_label')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Teks Link Detail</label>
                <input type="text" name="sections[grid][detail_label]" value="{{ old('sections.grid.detail_label', data_get($content, 'grid.detail_label')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Label Level Default</label>
                <input type="text" name="sections[grid][default_level_label]" value="{{ old('sections.grid.default_level_label', data_get($content, 'grid.default_level_label')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Label Kategori Default</label>
                <input type="text" name="sections[grid][default_category_label]" value="{{ old('sections.grid.default_category_label', data_get($content, 'grid.default_category_label')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
        </div>
    </div>

    <!-- NEWSLETTER SECTION -->
    <div class="bg-white rounded-[2rem] border border-primary/5 shadow-sm p-6 lg:p-8 space-y-6">
        <h2 class="text-xl font-bold text-primary flex items-center gap-2 pb-4 border-b border-primary/5">
            <span class="material-symbols-outlined">mail_outline</span>
            Section 4: Call to Action (Newsletter)
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Judul Card Newsletter</label>
                <input type="text" name="sections[newsletter][title]" value="{{ old('sections.newsletter.title', data_get($content, 'newsletter.title')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Placeholder Email</label>
                <input type="text" name="sections[newsletter][email_placeholder]" value="{{ old('sections.newsletter.email_placeholder', data_get($content, 'newsletter.email_placeholder')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Label Tombol Daftar</label>
                <input type="text" name="sections[newsletter][button_label]" value="{{ old('sections.newsletter.button_label', data_get($content, 'newsletter.button_label')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-on-surface mb-2">Deskripsi Newsletter</label>
            <textarea name="sections[newsletter][description]" rows="3" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface resize-y" required>{{ old('sections.newsletter.description', data_get($content, 'newsletter.description')) }}</textarea>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end gap-4 bg-white p-6 rounded-3xl border border-primary/5 shadow-sm">
        <a href="{{ route('admin.pages.index') }}" class="px-6 py-3 text-on-surface-variant hover:text-on-surface font-bold transition-colors">
            Batal
        </a>
        <button type="submit" class="px-8 py-3 bg-primary text-white font-bold rounded-2xl hover:bg-primary/90 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
            Simpan Perubahan
        </button>
    </div>
</form>
@endsection
