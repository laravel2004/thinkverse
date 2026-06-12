@extends('layouts.admin')

@section('title', 'Edit Halaman Utama')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 mb-2 text-sm font-medium text-on-surface-variant">
        <a href="{{ route('admin.pages.index') }}" class="hover:text-primary transition-colors">Konten Halaman</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span class="text-on-surface">Home</span>
    </div>
    <h1 class="font-display-lg text-3xl font-extrabold text-on-surface">Edit Halaman Utama (Home)</h1>
    <p class="text-on-surface-variant font-medium mt-1">Ubah konten pemasaran di halaman utama Anda.</p>
</div>

<form action="{{ route('admin.pages.update', 'home') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')

    <!-- HERO SECTION -->
    <div class="bg-white rounded-[2rem] border border-primary/5 shadow-sm p-6 lg:p-8 space-y-6">
        <h2 class="text-xl font-bold text-primary flex items-center gap-2 pb-4 border-b border-primary/5">
            <span class="material-symbols-outlined">home</span>
            Section 1: Hero Pemasaran
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Badge Text</label>
                <input type="text" name="sections[hero][badge]" value="{{ old('sections.hero.badge', data_get($content, 'hero.badge')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Stat Badge Number</label>
                <input type="text" name="sections[hero][stat_number]" value="{{ old('sections.hero.stat_number', data_get($content, 'hero.stat_number')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Stat Badge Label</label>
                <input type="text" name="sections[hero][stat_label]" value="{{ old('sections.hero.stat_label', data_get($content, 'hero.stat_label')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Image Alt Text</label>
                <input type="text" name="sections[hero][image_alt]" value="{{ old('sections.hero.image_alt', data_get($content, 'hero.image_alt')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Title Sebelum Highlight</label>
                <input type="text" name="sections[hero][title_before_highlight]" value="{{ old('sections.hero.title_before_highlight', data_get($content, 'hero.title_before_highlight')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface">
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Title Highlighted Text</label>
                <input type="text" name="sections[hero][title_highlight]" value="{{ old('sections.hero.title_highlight', data_get($content, 'hero.title_highlight')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Title Setelah Highlight</label>
                <input type="text" name="sections[hero][title_after_highlight]" value="{{ old('sections.hero.title_after_highlight', data_get($content, 'hero.title_after_highlight')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface">
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
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Tautan / URL</label>
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
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Tautan / URL</label>
                    <input type="text" name="sections[hero][secondary_button_url]" value="{{ old('sections.hero.secondary_button_url', data_get($content, 'hero.secondary_button_url')) }}" class="w-full px-4 py-2.5 bg-white border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-on-surface text-sm" required>
                </div>
            </div>
        </div>

        <div class="p-4 bg-surface/50 rounded-2xl border border-primary/5">
            <label class="block text-sm font-bold text-on-surface mb-2">Gambar Dashboard Hero</label>
            @php
                $imageUrl = data_get($content, 'hero.image_url');
                $isExternal = Str::startsWith($imageUrl, ['http://', 'https://']);
                $resolvedImageUrl = $isExternal ? $imageUrl : Storage::url($imageUrl);
            @endphp
            @if($imageUrl)
                <div class="mb-4">
                    <img src="{{ $resolvedImageUrl }}" alt="Preview" class="w-48 h-32 object-cover rounded-xl border border-primary/10">
                </div>
            @endif
            <div class="relative group cursor-pointer w-48">
                <input type="file" name="hero_image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                <div class="w-full h-24 border-2 border-dashed border-primary/20 bg-white rounded-xl flex flex-col items-center justify-center text-on-surface-variant group-hover:border-primary/50 group-hover:bg-primary/5 transition-all">
                    <span class="material-symbols-outlined text-2xl mb-1">add_photo_alternate</span>
                    <span class="text-xs font-medium">Klik Ganti Gambar</span>
                </div>
            </div>
        </div>
    </div>

    <!-- FOUNDER SECTION -->
    <div class="bg-white rounded-[2rem] border border-primary/5 shadow-sm p-6 lg:p-8 space-y-6">
        <h2 class="text-xl font-bold text-primary flex items-center gap-2 pb-4 border-b border-primary/5">
            <span class="material-symbols-outlined">person</span>
            Section 2: Profil Founder & Lead Mentor
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Nama Founder</label>
                <input type="text" name="sections[founder][name]" value="{{ old('sections.founder.name', data_get($content, 'founder.name')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Peran / Jabatan</label>
                <input type="text" name="sections[founder][role]" value="{{ old('sections.founder.role', data_get($content, 'founder.role')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-on-surface mb-2">Kutipan Utama (Quote)</label>
            <textarea name="sections[founder][quote]" rows="2" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface resize-y" required>{{ old('sections.founder.quote', data_get($content, 'founder.quote')) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-bold text-on-surface mb-2">Biografi Pendek</label>
            <textarea name="sections[founder][bio]" rows="3" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface resize-y" required>{{ old('sections.founder.bio', data_get($content, 'founder.bio')) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Social Links -->
            <div class="p-4 bg-surface/50 rounded-2xl border border-primary/5 space-y-4">
                <h3 class="font-bold text-sm text-on-surface">Tautan Sosial Founder</h3>
                @foreach(data_get($content, 'founder.social_links', []) as $idx => $link)
                <div class="p-3 bg-white rounded-xl border border-primary/5 space-y-2">
                    <input type="hidden" name="sections[founder][social_links][{{ $idx }}][icon]" value="{{ $link['icon'] }}">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px] text-primary">{{ $link['icon'] }}</span>
                        <input type="text" name="sections[founder][social_links][{{ $idx }}][label]" value="{{ $link['label'] }}" class="flex-1 px-3 py-1 bg-surface border-none rounded-lg text-xs" placeholder="Label" required>
                    </div>
                    <input type="text" name="sections[founder][social_links][{{ $idx }}][url]" value="{{ $link['url'] }}" class="w-full px-3 py-1 bg-surface border-none rounded-lg text-xs" placeholder="URL" required>
                </div>
                @endforeach
            </div>

            <!-- Founder Photo -->
            <div class="p-4 bg-surface/50 rounded-2xl border border-primary/5">
                <label class="block text-sm font-bold text-on-surface mb-2">Foto Founder</label>
                @php
                    $photoUrl = data_get($content, 'founder.photo_url');
                    $isPhotoExternal = Str::startsWith($photoUrl, ['http://', 'https://']);
                    $resolvedPhotoUrl = $isPhotoExternal ? $photoUrl : Storage::url($photoUrl);
                @endphp
                @if($photoUrl)
                    <div class="mb-4">
                        <img src="{{ $resolvedPhotoUrl }}" alt="Preview" class="w-32 h-40 object-cover rounded-xl border border-primary/10">
                    </div>
                @endif
                <div class="relative group cursor-pointer w-32">
                    <input type="file" name="founder_photo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div class="w-full h-20 border-2 border-dashed border-primary/20 bg-white rounded-xl flex flex-col items-center justify-center text-on-surface-variant group-hover:border-primary/50 group-hover:bg-primary/5 transition-all">
                        <span class="material-symbols-outlined text-2xl mb-1">add_photo_alternate</span>
                        <span class="text-[10px] font-medium">Klik Ganti Foto</span>
                    </div>
                </div>
                <input type="hidden" name="sections[founder][photo_alt]" value="{{ data_get($content, 'founder.photo_alt', 'Founder Photo') }}">
            </div>
        </div>
    </div>

    <!-- FEATURES SECTION -->
    <div class="bg-white rounded-[2rem] border border-primary/5 shadow-sm p-6 lg:p-8 space-y-6">
        <h2 class="text-xl font-bold text-primary flex items-center gap-2 pb-4 border-b border-primary/5">
            <span class="material-symbols-outlined">menu_book</span>
            Section 3: Kenapa Belajar di Sini (Fitur)
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Judul Section Fitur</label>
                <input type="text" name="sections[features][title]" value="{{ old('sections.features.title', data_get($content, 'features.title')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Deskripsi Section Fitur</label>
                <textarea name="sections[features][description]" rows="2" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface resize-y" required>{{ old('sections.features.description', data_get($content, 'features.description')) }}</textarea>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach(data_get($content, 'features.items', []) as $idx => $item)
            <div class="p-4 bg-surface/50 rounded-2xl border border-primary/5 space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-primary/5">
                    <span class="text-xs font-bold text-primary">Kartu {{ $idx + 1 }}</span>
                    <input type="text" name="sections[features][items][{{ $idx }}][icon]" value="{{ $item['icon'] }}" class="w-20 px-2 py-1 bg-white border-none rounded-lg text-xs" placeholder="Icon" required>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-on-surface-variant mb-1">Judul Fitur</label>
                    <input type="text" name="sections[features][items][{{ $idx }}][title]" value="{{ $item['title'] }}" class="w-full px-3 py-2 bg-white border-none rounded-xl text-xs" required>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-on-surface-variant mb-1">Deskripsi Fitur</label>
                    <textarea name="sections[features][items][{{ $idx }}][description]" rows="3" class="w-full px-3 py-2 bg-white border-none rounded-xl text-xs" required>{{ $item['description'] }}</textarea>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-on-surface-variant mb-1">Varian Warna</label>
                    <input type="text" name="sections[features][items][{{ $idx }}][color_variant]" value="{{ $item['color_variant'] }}" class="w-full px-3 py-2 bg-white border-none rounded-xl text-xs" required>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- COURSE PREVIEW SECTION -->
    <div class="bg-white rounded-[2rem] border border-primary/5 shadow-sm p-6 lg:p-8 space-y-6">
        <h2 class="text-xl font-bold text-primary flex items-center gap-2 pb-4 border-b border-primary/5">
            <span class="material-symbols-outlined">visibility</span>
            Section 4: Katalog Preview
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Judul Katalog Preview</label>
                <input type="text" name="sections[course_preview][title]" value="{{ old('sections.course_preview.title', data_get($content, 'course_preview.title')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Deskripsi Katalog Preview</label>
                <textarea name="sections[course_preview][description]" rows="2" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface resize-y" required>{{ old('sections.course_preview.description', data_get($content, 'course_preview.description')) }}</textarea>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Label Link Katalog</label>
                <input type="text" name="sections[course_preview][link_label]" value="{{ old('sections.course_preview.link_label', data_get($content, 'course_preview.link_label')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">URL Link Katalog</label>
                <input type="text" name="sections[course_preview][link_url]" value="{{ old('sections.course_preview.link_url', data_get($content, 'course_preview.link_url')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Text Saat Kursus Kosong</label>
                <input type="text" name="sections[course_preview][empty_state_text]" value="{{ old('sections.course_preview.empty_state_text', data_get($content, 'course_preview.empty_state_text')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
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
