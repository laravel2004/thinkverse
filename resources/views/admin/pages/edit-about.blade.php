@extends('layouts.admin')

@section('title', 'Edit Halaman Tentang Kami')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 mb-2 text-sm font-medium text-on-surface-variant">
        <a href="{{ route('admin.pages.index') }}" class="hover:text-primary transition-colors">Konten Halaman</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span class="text-on-surface">About</span>
    </div>
    <h1 class="font-display-lg text-3xl font-extrabold text-on-surface">Edit Halaman Tentang Kami (About)</h1>
    <p class="text-on-surface-variant font-medium mt-1">Ubah konten visi misi dan informasi lainnya pada halaman Tentang Kami.</p>
</div>

<form action="{{ route('admin.pages.update', 'about') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')

    <!-- HERO SECTION -->
    <div class="bg-white rounded-[2rem] border border-primary/5 shadow-sm p-6 lg:p-8 space-y-6">
        <h2 class="text-xl font-bold text-primary flex items-center gap-2 pb-4 border-b border-primary/5">
            <span class="material-symbols-outlined">info</span>
            Section 1: Hero Halaman
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-on-surface mb-2">Meta Title Halaman</label>
                <input type="text" name="sections[hero][page_title]" value="{{ old('sections.hero.page_title', data_get($content, 'hero.page_title')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Badge Text</label>
                <input type="text" name="sections[hero][badge]" value="{{ old('sections.hero.badge', data_get($content, 'hero.badge')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Title Sebelum Highlight</label>
                <input type="text" name="sections[hero][title_before_highlight]" value="{{ old('sections.hero.title_before_highlight', data_get($content, 'hero.title_before_highlight')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface">
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Title Highlighted Text</label>
                <input type="text" name="sections[hero][title_highlight]" value="{{ old('sections.hero.title_highlight', data_get($content, 'hero.title_highlight')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-on-surface mb-2">Deskripsi Hero</label>
            <textarea name="sections[hero][description]" rows="3" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface resize-y" required>{{ old('sections.hero.description', data_get($content, 'hero.description')) }}</textarea>
        </div>
    </div>

    <!-- VISION SECTION -->
    <div class="bg-white rounded-[2rem] border border-primary/5 shadow-sm p-6 lg:p-8 space-y-6">
        <h2 class="text-xl font-bold text-primary flex items-center gap-2 pb-4 border-b border-primary/5">
            <span class="material-symbols-outlined">lightbulb</span>
            Section 2: Visi & Nilai Inti
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Judul Section Visi</label>
                <input type="text" name="sections[vision][title]" value="{{ old('sections.vision.title', data_get($content, 'vision.title')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Alt Text Gambar</label>
                <input type="text" name="sections[vision][image_alt]" value="{{ old('sections.vision.image_alt', data_get($content, 'vision.image_alt')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
        </div>

        <div class="space-y-4">
            <label class="block text-sm font-bold text-on-surface mb-2">Paragraf Konten Visi</label>
            @php
                $paragraphs = data_get($content, 'vision.paragraphs', []);
            @endphp
            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1">Paragraf 1</label>
                <textarea name="sections[vision][paragraphs][0]" rows="3" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface resize-y" required>{{ old('sections.vision.paragraphs.0', $paragraphs[0] ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1">Paragraf 2</label>
                <textarea name="sections[vision][paragraphs][1]" rows="3" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface resize-y" required>{{ old('sections.vision.paragraphs.1', $paragraphs[1] ?? '') }}</textarea>
            </div>
        </div>

        <div class="p-4 bg-surface/50 rounded-2xl border border-primary/5">
            <label class="block text-sm font-bold text-on-surface mb-2">Gambar Visi / Tim</label>
            @php
                $visionImage = data_get($content, 'vision.image_url');
                $isImageExternal = Str::startsWith($visionImage, ['http://', 'https://']);
                $resolvedVisionImage = $isImageExternal ? $visionImage : Storage::url($visionImage);
            @endphp
            @if($visionImage)
                <div class="mb-4">
                    <img src="{{ $resolvedVisionImage }}" alt="Preview" class="w-48 h-48 object-cover rounded-xl border border-primary/10">
                </div>
            @endif
            <div class="relative group cursor-pointer w-48">
                <input type="file" name="vision_image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                <div class="w-full h-24 border-2 border-dashed border-primary/20 bg-white rounded-xl flex flex-col items-center justify-center text-on-surface-variant group-hover:border-primary/50 group-hover:bg-primary/5 transition-all">
                    <span class="material-symbols-outlined text-2xl mb-1">add_photo_alternate</span>
                    <span class="text-xs font-medium">Klik Ganti Gambar</span>
                </div>
            </div>
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
